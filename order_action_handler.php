<?php
header('Content-Type: application/json');
require_once 'includes/db.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    echo json_encode(['success' => false, 'message' => 'Invalid request method']);
    exit;
}

$action = $_POST['action'] ?? null;
$orderId = $_POST['order_id'] ?? null;
$itemName = $_POST['item_name'] ?? null;
$reason = trim($_POST['reason'] ?? '');

if (!$action || !$orderId || !$itemName) {
    echo json_encode(['success' => false, 'message' => 'Missing required parameters']);
    exit;
}

try {
    // Log incoming request for debugging
    file_put_contents(
        'order_actions.log',
        date('Y-m-d H:i:s') . " - Action: $action, OrderID: $orderId, Item: $itemName, Reason: $reason\n",
        FILE_APPEND
    );

    if ($action === 'cancel') {
        // Get order details
        $stmt = $pdo->prepare("SELECT id, user_id FROM orders WHERE id = ?");
        $stmt->execute([$orderId]);
        $order = $stmt->fetch();

        if (!$order) {
            file_put_contents('order_actions.log', "  -> ERROR: Order not found\n", FILE_APPEND);
            echo json_encode(['success' => false, 'message' => 'Order not found']);
            exit;
        }
        file_put_contents('order_actions.log', "  -> Order found, User ID: " . $order['user_id'] . "\n", FILE_APPEND);

        // Get item details
        $stmt = $pdo->prepare("SELECT product_name, price, qty, size FROM order_items WHERE order_id = ? AND product_name = ?");
        $stmt->execute([$orderId, $itemName]);
        $item = $stmt->fetch();

        if (!$item) {
            file_put_contents('order_actions.log', "  -> ERROR: Item not found\n", FILE_APPEND);
            echo json_encode(['success' => false, 'message' => 'Item not found in order']);
            exit;
        }
        file_put_contents('order_actions.log', "  -> Item found: " . $itemName . "\n", FILE_APPEND);

        // Record cancellation
        $stmt = $pdo->prepare("INSERT INTO cancellations (user_id, order_id, product_name, quantity, price, size, cancel_reason)
                               VALUES (?, ?, ?, ?, ?, ?, ?)");
        $stmt->execute([
            $order['user_id'],
            $orderId,
            $itemName,
            $item['qty'],
            $item['price'],
            $item['size'],
            $reason
        ]);
        $cancellationId = $pdo->lastInsertId();
        file_put_contents('order_actions.log', "  -> Cancellation recorded, ID: $cancellationId\n", FILE_APPEND);

        // Update order item status
        $stmt = $pdo->prepare("UPDATE order_items SET status = 'Cancelled', cancelled_at = NOW(), cancel_reason = ?
                               WHERE order_id = ? AND product_name = ?");
        $stmt->execute([$reason, $orderId, $itemName]);
        file_put_contents('order_actions.log', "  -> Order item status updated to Cancelled\n", FILE_APPEND);

        echo json_encode([
            'success' => true,
            'message' => 'Cancellation request submitted',
            'cancellation_id' => $cancellationId
        ]);

    } else if ($action === 'replacement') {
        // Get order details
        $stmt = $pdo->prepare("SELECT id, user_id FROM orders WHERE id = ?");
        $stmt->execute([$orderId]);
        $order = $stmt->fetch();

        if (!$order) {
            echo json_encode(['success' => false, 'message' => 'Order not found']);
            exit;
        }

        // Get item details
        $stmt = $pdo->prepare("SELECT product_name, price FROM order_items WHERE order_id = ? AND product_name = ?");
        $stmt->execute([$orderId, $itemName]);
        $item = $stmt->fetch();

        if (!$item) {
            echo json_encode(['success' => false, 'message' => 'Item not found in order']);
            exit;
        }

        // For replacement, we log it (in a real system, create a replacement request)
        // For now, we can update order item status to "Replacement Requested"
        $stmt = $pdo->prepare("UPDATE order_items SET status = 'Replacement Requested', cancel_reason = ?
                               WHERE order_id = ? AND product_name = ?");
        $stmt->execute([$reason, $orderId, $itemName]);

        echo json_encode([
            'success' => true,
            'message' => 'Replacement request submitted'
        ]);

    } else {
        echo json_encode(['success' => false, 'message' => 'Invalid action']);
    }

} catch (Exception $e) {
    file_put_contents('order_actions.log', "  -> EXCEPTION: " . $e->getMessage() . "\n", FILE_APPEND);
    echo json_encode(['success' => false, 'message' => 'Database error: ' . $e->getMessage()]);
}
?>
