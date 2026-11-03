<?php
header('Content-Type: application/json');
require_once 'includes/db.php';

// Get JSON data from request
$json = file_get_contents('php://input');
$data = json_decode($json, true);

// Log incoming request
$logData = [
    'timestamp' => date('Y-m-d H:i:s'),
    'json_received' => $json,
    'decoded_data' => $data,
    'json_error' => json_last_error_msg()
];
file_put_contents('checkout_orders.log', json_encode($logData, JSON_PRETTY_PRINT) . "\n---\n", FILE_APPEND);

if (!$data) {
    $errorMsg = 'Invalid data received. JSON Error: ' . json_last_error_msg();
    file_put_contents('checkout_orders.log', "ERROR: $errorMsg\n\n", FILE_APPEND);
    echo json_encode(['success' => false, 'message' => $errorMsg]);
    exit;
}

try {
    file_put_contents('checkout_orders.log', "Processing order with subtotal: " . $data['subtotal'] . "\n", FILE_APPEND);
    
    // Generate a unique Tracking ID: ORD-YYYY-随机数
    $trackingId = 'ORD-' . date('Y') . '-' . strtoupper(substr(md5(uniqid()), 0, 6));
    file_put_contents('checkout_orders.log', "Generated tracking ID: $trackingId\n", FILE_APPEND);

    // Calculate totals on server for security
    $subtotal = floatval($data['subtotal']);
    $tax = $subtotal * 0.18;
    $total = $subtotal + $tax;

    // Start Transaction
    $pdo->beginTransaction();
    file_put_contents('checkout_orders.log', "Transaction started\n", FILE_APPEND);

    // 1. Insert into orders table
    $stmt = $pdo->prepare("INSERT INTO orders (id, user_id, name, mobile, pincode, street, city, state, payment_method, payment_details, subtotal, tax, total, status) 
                            VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, 'Placed')");
    $orderParams = [
        $trackingId,
        $data['user_id'] ?? null,
        $data['name'],
        $data['mobile'],
        $data['pincode'],
        $data['street'],
        $data['city'],
        $data['state'],
        $data['payment_method'],
        $data['payment_details'] ?? null,
        $subtotal,
        $tax,
        $total
    ];
    
    file_put_contents('checkout_orders.log', "Order insert params: " . json_encode($orderParams) . "\n", FILE_APPEND);
    $stmt->execute($orderParams);
    file_put_contents('checkout_orders.log', "Order inserted successfully\n", FILE_APPEND);

    // 2. Insert into order_items table
    $itemsStmt = $pdo->prepare("INSERT INTO order_items (order_id, product_name, price, qty, size) VALUES (?, ?, ?, ?, ?)");
    foreach ($data['items'] as $item) {
        $itemParams = [
            $trackingId,
            $item['name'],
            floatval($item['price']),
            intval($item['qty']),
            $item['size']
        ];
        file_put_contents('checkout_orders.log', "Item insert params: " . json_encode($itemParams) . "\n", FILE_APPEND);
        $itemsStmt->execute($itemParams);
    }
    file_put_contents('checkout_orders.log', "All items inserted successfully\n", FILE_APPEND);

    $pdo->commit();
    file_put_contents('checkout_orders.log', "Transaction committed successfully\n\n", FILE_APPEND);

    echo json_encode([
        'success' => true, 
        'tracking_id' => $trackingId,
        'message' => 'Order placed successfully!'
    ]);

} catch (Exception $e) {
    file_put_contents('checkout_orders.log', "ERROR: " . $e->getMessage() . "\n", FILE_APPEND);
    file_put_contents('checkout_orders.log', "Trace: " . $e->getTraceAsString() . "\n\n", FILE_APPEND);
    
    if (isset($pdo)) $pdo->rollBack();
    echo json_encode(['success' => false, 'message' => 'Error: ' . $e->getMessage()]);
}
?>
