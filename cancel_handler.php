<?php
header('Content-Type: application/json');
include 'includes/db.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    echo json_encode(['success' => false, 'message' => 'Invalid request method']);
    exit;
}

$userId = $_POST['user_id'] ?? null;
$orderId = $_POST['order_id'] ?? null;
$productName = trim($_POST['product_name'] ?? '');
$quantity = (int)($_POST['quantity'] ?? 1);
$price = (float)($_POST['price'] ?? 0);
$size = trim($_POST['size'] ?? '');
$reason = trim($_POST['reason'] ?? 'User cancelled');

if (empty($productName) || $price <= 0) {
    echo json_encode(['success' => false, 'message' => 'Invalid product data']);
    exit;
}

try {
    // Insert cancellation record
    $stmt = $pdo->prepare("INSERT INTO cancellations (user_id, order_id, product_name, quantity, price, size, cancel_reason) VALUES (?, ?, ?, ?, ?, ?, ?)");
    $stmt->execute([$userId, $orderId, $productName, $quantity, $price, $size, $reason]);

    // Update order item status if order_id is provided
    if ($orderId) {
        $stmt = $pdo->prepare("UPDATE order_items SET status = 'Cancelled', cancelled_at = NOW(), cancel_reason = ? WHERE order_id = ? AND product_name = ? AND size = ?");
        $stmt->execute([$reason, $orderId, $productName, $size]);
    }

    echo json_encode([
        'success' => true,
        'message' => 'Product cancellation recorded successfully',
        'cancellation_id' => $pdo->lastInsertId()
    ]);

} catch (Exception $e) {
    echo json_encode(['success' => false, 'message' => 'Database error: ' . $e->getMessage()]);
}
?>