<?php
require_once 'includes/db.php';

try {
    // Check table structure
    $result = $pdo->query("DESCRIBE orders");
    $columns = $result->fetchAll(PDO::FETCH_ASSOC);
    
    echo "<h2>Orders Table Structure:</h2>";
    echo "<table border='1' cellpadding='5'>";
    echo "<tr><th>Field</th><th>Type</th><th>Null</th><th>Key</th><th>Default</th><th>Extra</th></tr>";
    foreach ($columns as $col) {
        echo "<tr>";
        echo "<td>" . htmlspecialchars($col['Field']) . "</td>";
        echo "<td>" . htmlspecialchars($col['Type']) . "</td>";
        echo "<td>" . htmlspecialchars($col['Null']) . "</td>";
        echo "<td>" . htmlspecialchars($col['Key']) . "</td>";
        echo "<td>" . htmlspecialchars($col['Default'] ?? 'NULL') . "</td>";
        echo "<td>" . htmlspecialchars($col['Extra']) . "</td>";
        echo "</tr>";
    }
    echo "</table>";
    
    // Check existing orders
    echo "<h2>Orders in Database:</h2>";
    $orders = $pdo->query("SELECT id, user_id, name, payment_method, created_at FROM orders ORDER BY created_at DESC LIMIT 10");
    $orderList = $orders->fetchAll(PDO::FETCH_ASSOC);
    
    if (empty($orderList)) {
        echo "<p style='color: red;'><strong>No orders found in database</strong></p>";
    } else {
        echo "<table border='1' cellpadding='5'>";
        echo "<tr><th>Order ID</th><th>User ID</th><th>Name</th><th>Payment Method</th><th>Created At</th></tr>";
        foreach ($orderList as $order) {
            echo "<tr>";
            echo "<td>" . htmlspecialchars($order['id']) . "</td>";
            echo "<td>" . htmlspecialchars($order['user_id'] ?? 'NULL') . "</td>";
            echo "<td>" . htmlspecialchars($order['name']) . "</td>";
            echo "<td>" . htmlspecialchars($order['payment_method']) . "</td>";
            echo "<td>" . htmlspecialchars($order['created_at']) . "</td>";
            echo "</tr>";
        }
        echo "</table>";
    }
    
    // Check checkout log
    echo "<h2>Checkout Log:</h2>";
    if (file_exists('checkout_orders.log')) {
        echo "<pre style='background: #f0f0f0; padding: 10px; overflow-x: auto; height: 300px;'>";
        echo htmlspecialchars(file_get_contents('checkout_orders.log'));
        echo "</pre>";
    } else {
        echo "<p>No checkout log file yet.</p>";
    }
    
} catch (Exception $e) {
    echo "Error: " . $e->getMessage();
}
?>
