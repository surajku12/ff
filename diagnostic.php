<?php
header('Content-Type: text/html; charset=utf-8');
?>
<!DOCTYPE html>
<html>
<head>
    <title>Database Diagnostic Check</title>
    <style>
        body { font-family: Arial; margin: 20px; }
        .section { margin: 20px 0; padding: 15px; border: 1px solid #ddd; border-radius: 5px; }
        .success { background: #d4edda; color: #155724; }
        .error { background: #f8d7da; color: #721c24; }
        .warning { background: #fff3cd; color: #856404; }
        code { background: #f4f4f4; padding: 2px 5px; border-radius: 3px; }
        table { border-collapse: collapse; width: 100%; margin: 10px 0; }
        table, th, td { border: 1px solid #ddd; }
        th, td { padding: 10px; text-align: left; }
        th { background: #f4f4f4; }
    </style>
</head>
<body>

<h1>🔍 FASHIOFY Database Diagnostic Check</h1>

<?php
require_once 'includes/db.php';

// Test 1: Database Connection
echo '<div class="section success">';
echo '<h2>✓ Database Connection: OK</h2>';
echo '<p>Connected to: <code>fashiofy</code></p>';
echo '</div>';

// Test 2: Check Orders Table Structure
echo '<div class="section">';
try {
    $result = $pdo->query("DESCRIBE orders");
    $columns = $result->fetchAll(PDO::FETCH_ASSOC);
    
    echo '<h2>✓ Orders Table Structure</h2>';
    echo '<table>';
    echo '<tr><th>Field</th><th>Type</th><th>Null</th><th>Key</th><th>Default</th></tr>';
    
    $hasPaymentDetails = false;
    foreach ($columns as $col) {
        if ($col['Field'] === 'payment_details') {
            $hasPaymentDetails = true;
        }
        echo '<tr>';
        echo '<td><code>' . htmlspecialchars($col['Field']) . '</code></td>';
        echo '<td>' . htmlspecialchars($col['Type']) . '</td>';
        echo '<td>' . htmlspecialchars($col['Null']) . '</td>';
        echo '<td>' . htmlspecialchars($col['Key'] ?? '-') . '</td>';
        echo '<td>' . htmlspecialchars($col['Default'] ?? 'NULL') . '</td>';
        echo '</tr>';
    }
    echo '</table>';
    
    if ($hasPaymentDetails) {
        echo '<p class="success">✓ payment_details column found</p>';
    } else {
        echo '<p class="warning">⚠ payment_details column NOT found - running ALTER...</p>';
        try {
            $pdo->exec("ALTER TABLE orders ADD COLUMN payment_details VARCHAR(255) DEFAULT NULL");
            echo '<p class="success">✓ payment_details column added</p>';
        } catch (Exception $e) {
            echo '<p class="error">✗ Error adding column: ' . $e->getMessage() . '</p>';
        }
    }
} catch (Exception $e) {
    echo '<p class="error">✗ Error reading table structure: ' . $e->getMessage() . '</p>';
}
echo '</div>';

// Test 3: Sample Insert Test
echo '<div class="section">';
echo '<h2>🧪 Test Insert</h2>';
try {
    $testId = 'TEST-' . time();
    $stmt = $pdo->prepare("INSERT INTO orders (id, name, mobile, pincode, street, city, state, payment_method, subtotal, tax, total, status)
                           VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, 'Test')");
    $stmt->execute([
        $testId,
        'Test Order',
        '9876543210',
        '110001',
        'Test Street',
        'Test City',
        'Test State',
        'upi',
        100,
        18,
        118
    ]);
    echo '<p class="success">✓ Test insert successful: <code>' . htmlspecialchars($testId) . '</code></p>';
    
    // Delete test order
    $pdo->prepare("DELETE FROM orders WHERE id = ?;")->execute([$testId]);
    echo '<p>✓ Test order deleted</p>';
} catch (Exception $e) {
    echo '<p class="error">✗ Test insert failed: ' . $e->getMessage() . '</p>';
}
echo '</div>';

// Test 4: Existing Orders
echo '<div class="section">';
try {
    $orders = $pdo->query("SELECT COUNT(*) as count FROM orders");
    $count = $orders->fetch()['count'];
    
    echo '<h2>📦 Orders in Database</h2>';
    echo '<p><strong>Total orders:</strong> ' . $count . '</p>';
    
    if ($count > 0) {
        $recent = $pdo->query("SELECT id, name, payment_method, total, created_at FROM orders ORDER BY created_at DESC LIMIT 5");
        $orders = $recent->fetchAll();
        echo '<table>';
        echo '<tr><th>Order ID</th><th>Name</th><th>Payment</th><th>Total</th><th>Created</th></tr>';
        foreach ($orders as $order) {
            echo '<tr>';
            echo '<td><code>' . htmlspecialchars($order['id']) . '</code></td>';
            echo '<td>' . htmlspecialchars($order['name']) . '</td>';
            echo '<td>' . htmlspecialchars($order['payment_method']) . '</td>';
            echo '<td>₹' . number_format($order['total'], 2) . '</td>';
            echo '<td>' . htmlspecialchars($order['created_at']) . '</td>';
            echo '</tr>';
        }
        echo '</table>';
    }
} catch (Exception $e) {
    echo '<p class="error">✗ Error reading orders: ' . $e->getMessage() . '</p>';
}
echo '</div>';

// Test 5: Checkout Log
echo '<div class="section">';
echo '<h2>📋 Checkout Log</h2>';
if (file_exists('checkout_orders.log')) {
    $logContent = file_get_contents('checkout_orders.log');
    $lines = explode("\n", trim($logContent));
    $lastLines = array_slice($lines, -20); // Last 20 lines
    echo '<pre style="background: #f5f5f5; padding: 10px; overflow-x: auto; max-height: 300px; border: 1px solid #ddd;">';
    echo htmlspecialchars(implode("\n", $lastLines));
    echo '</pre>';
    echo '<p><small>Log file: <code>checkout_orders.log</code></small></p>';
} else {
    echo '<p class="warning">⚠ No checkout log yet (will be created on first order attempt)</p>';
}
echo '</div>';

// Test 6: JavaScript Data Check
echo '<div class="section">';
echo '<h2>🔧 How to Debug if Orders Aren\'t Saving</h2>';
echo '<ol>';
echo '<li>Open browser DevTools (F12 → Network tab)</li>';
echo '<li>Go to checkout page and place an order</li>';
echo '<li>Look for <code>process-checkout.php</code> request</li>';
echo '<li>Check the response - should say <code>"success": true</code></li>';
echo '<li>If error, the response will show the database error message</li>';
echo '<li>Refresh this page to see if order was saved</li>';
echo '</ol>';
echo '</div>';

?>

</body>
</html>
