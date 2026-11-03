<?php
header('Content-Type: text/html; charset=utf-8');
error_reporting(E_ALL);
ini_set('display_errors', 1);

session_start();
require_once 'includes/db.php';
$diagnostics = [];

// 1. Check database connection
try {
    $pdo->query("SELECT 1");
    $diagnostics['Database Connection'] = ['status' => 'OK', 'details' => 'PDO connection working'];
} catch (Exception $e) {
    $diagnostics['Database Connection'] = ['status' => 'ERROR', 'details' => $e->getMessage()];
}

// 2. Check required tables
$required_tables = ['users', 'login_logs', 'orders', 'order_items', 'cancellations'];
foreach ($required_tables as $table) {
    try {
        $stmt = $pdo->query("SHOW TABLES LIKE '$table'");
        $exists = $stmt->fetch();
        $diagnostics["Table: $table"] = ['status' => $exists ? 'OK' : 'MISSING', 'details' => $exists ? "Table exists" : "Table not found"];
    } catch (Exception $e) {
        $diagnostics["Table: $table"] = ['status' => 'ERROR', 'details' => $e->getMessage()];
    }
}

// 3. Check if user is logged in
$diagnostics['User Session'] = ['status' => isset($_SESSION['user_id']) ? 'LOGGED IN' : 'NOT LOGGED IN', 'details' => isset($_SESSION['user_id']) ? "User ID: {$_SESSION['user_id']}" : "Please log in to test"];

// 4. Check required PHP files exist
$required_files = [
    'includes/db.php',
    'checkout.php',
    'order-tracking.php',
    'order_action_handler.php',
    'script.js',
    'process-checkout.php',
    'login_handler.php'
];

foreach ($required_files as $file) {
    $path = __DIR__ . '/' . $file;
    $diagnostics["File: $file"] = ['status' => file_exists($path) ? 'OK' : 'MISSING', 'details' => file_exists($path) ? "File size: " . filesize($path) . " bytes" : "File not found"];
}

// 5. Check if log files are writable
$log_files = ['order_actions.log', 'checkout_orders.log'];
foreach ($log_files as $logfile) {
    $path = __DIR__ . '/' . $logfile;
    if (file_exists($path)) {
        $diagnostics["Log: $logfile"] = ['status' => is_writable($path) ? 'OK' : 'READ-ONLY', 'details' => "File size: " . filesize($path) . " bytes"];
    } else {
        // Try to create it
        @file_put_contents($path, ""); 
        if (file_exists($path)) {
            $diagnostics["Log: $logfile"] = ['status' => 'OK', 'details' => "Created successfully"];
        } else {
            $diagnostics["Log: $logfile"] = ['status' => 'ERROR', 'details' => "Cannot create file"];
        }
    }
}

// 6. Sample order check
if (isset($_SESSION['user_id'])) {
    try {
        $stmt = $pdo->prepare("SELECT COUNT(*) as count FROM orders WHERE user_id = ?");
        $stmt->execute([$_SESSION['user_id']]);
        $result = $stmt->fetch();
        $diagnostics['Your Orders'] = ['status' => 'OK', 'details' => "You have {$result['count']} order(s)"];
    } catch (Exception $e) {
        $diagnostics['Your Orders'] = ['status' => 'ERROR', 'details' => $e->getMessage()];
    }
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>System Diagnostics</title>
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body { font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); min-height: 100vh; padding: 20px; }
        .container { max-width: 900px; margin: 0 auto; background: white; border-radius: 8px; box-shadow: 0 10px 40px rgba(0,0,0,0.2); overflow: hidden; }
        .header { background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); color: white; padding: 30px; text-align: center; }
        .header h1 { font-size: 2em; margin-bottom: 10px; }
        .header p { opacity: 0.9; }
        .content { padding: 30px; }
        .diagnostic-item { margin-bottom: 20px; padding: 15px; border-radius: 6px; border-left: 4px solid; display: flex; justify-content: space-between; align-items: center; }
        .status-ok { background: #e8f5e9; border-color: #27ae60; }
        .status-error { background: #ffebee; border-color: #e74c3c; }
        .status-warning { background: #fff3e0; border-color: #f39c12; }
        .diagnostic-info { flex: 1; }
        .diagnostic-name { font-weight: 600; color: #333; margin-bottom: 5px; }
        .diagnostic-details { font-size: 0.9em; color: #666; }
        .badge { padding: 5px 12px; border-radius: 20px; font-size: 0.85em; font-weight: 600; text-transform: uppercase; }
        .badge-ok { background: #27ae60; color: white; }
        .badge-error { background: #e74c3c; color: white; }
        .badge-warning { background: #f39c12; color: white; }
        .summary { background: #f5f5f5; padding: 20px; border-radius: 6px; margin-bottom: 30px; }
        .summary-stat { display: inline-block; margin-right: 30px; }
        .summary-stat-value { font-size: 2em; font-weight: 800; }
        .summary-stat-label { font-size: 0.9em; color: #666; margin-top: 5px; }
        .action-buttons { margin-top: 30px; display: flex; gap: 10px; flex-wrap: wrap; }
        button { padding: 12px 24px; border: none; border-radius: 4px; cursor: pointer; font-weight: 600; text-decoration: none; display: inline-block; }
        .btn-primary { background: #667eea; color: white; }
        .btn-primary:hover { background: #5568d3; }
        .btn-secondary { background: #e0e0e0; color: #333; }
        .btn-secondary:hover { background: #d0d0d0; }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>🔍 System Diagnostics</h1>
            <p>Check if all components are working correctly</p>
        </div>

        <div class="content">
            <div class="summary">
                <?php
                    $ok_count = count(array_filter($diagnostics, fn($item) => $item['status'] === 'OK'));
                    $error_count = count(array_filter($diagnostics, fn($item) => $item['status'] === 'ERROR'));
                    $warning_count = count(array_filter($diagnostics, fn($item) => strpos($item['status'], 'NOT') !== false));
                    $total = count($diagnostics);
                ?>
                <div class="summary-stat">
                    <div class="summary-stat-value" style="color: #27ae60;">✓ <?= $ok_count ?></div>
                    <div class="summary-stat-label">OK</div>
                </div>
                <div class="summary-stat">
                    <div class="summary-stat-value" style="color: #f39c12;">⚠ <?= $warning_count ?></div>
                    <div class="summary-stat-label">Warnings</div>
                </div>
                <div class="summary-stat">
                    <div class="summary-stat-value" style="color: #e74c3c;">✗ <?= $error_count ?></div>
                    <div class="summary-stat-label">Errors</div>
                </div>
            </div>

            <h2 style="margin-bottom: 20px; color: #333;">Diagnostic Results</h2>

            <?php foreach ($diagnostics as $name => $item): 
                $class = 'status-ok';
                $badgeClass = 'badge-ok';
                if ($item['status'] === 'ERROR') {
                    $class = 'status-error';
                    $badgeClass = 'badge-error';
                } elseif (strpos($item['status'], 'NOT') !== false || $item['status'] === 'READ-ONLY') {
                    $class = 'status-warning';
                    $badgeClass = 'badge-warning';
                }
            ?>
                <div class="diagnostic-item <?= $class ?>">
                    <div class="diagnostic-info">
                        <div class="diagnostic-name"><?= htmlspecialchars($name) ?></div>
                        <div class="diagnostic-details"><?= htmlspecialchars($item['details']) ?></div>
                    </div>
                    <span class="badge <?= $badgeClass ?>"><?= htmlspecialchars($item['status']) ?></span>
                </div>
            <?php endforeach; ?>

            <div style="margin-top: 40px; padding: 20px; background: #e3f2fd; border-radius: 6px; border-left: 4px solid #2196F3;">
                <h3 style="margin-bottom: 10px; color: #1976d2;">💡 What's Next?</h3>
                <ol style="margin-left: 20px; color: #555;">
                    <li><strong>If all items show "OK":</strong> Your system is ready! Go to <a href="checkout.php">checkout.php</a> to test payment forms.</li>
                    <li><strong>If "NOT LOGGED IN":</strong> <a href="login.php">Log in first</a> to test orders and cancel/replace buttons.</li>
                    <li><strong>If any ERROR items:</strong> Check the details and fix those issues before testing.</li>
                    <li><strong>To test payment forms:</strong> Go to <a href="https://localhost/kash/checkout.php" target="_blank">checkout page</a> and select each payment method in the dropdown.</li>
                    <li><strong>To test cancel/replace:</strong> <a href="order-tracking.php">View your orders</a> and click Cancel on any product.</li>
                </ol>
            </div>

            <div class="action-buttons">
                <a href="checkout.php" class="btn-primary">Open Checkout</a>
                <a href="order-tracking.php" class="btn-primary">View Orders</a>
                <a href="login.php" class="btn-secondary">Log In</a>
                <button class="btn-secondary" onclick="location.reload()">Refresh Diagnostics</button>
            </div>
        </div>
    </div>
</body>
</html>
