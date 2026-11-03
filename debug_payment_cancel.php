<?php
header('Content-Type: text/html; charset=utf-8');
?>
<!DOCTYPE html>
<html>
<head>
    <title>Payment & Cancel/Replace Debug</title>
    <style>
        body { font-family: Arial; margin: 20px; }
        .test-section { margin: 20px 0; padding: 20px; border: 2px solid #ddd; border-radius: 8px; }
        .success { border-color: #27ae60; background: #f0f8f6; }
        .error { border-color: #e74c3c; background: #fdf7f6; }
        .warning { border-color: #f39c12; background: #fff9f0; }
        code { background: #f4f4f4; padding: 5px 10px; border-radius: 4px; font-family: monospace; }
        h2 { margin-top: 0; }
        .file-check { margin: 10px 0; }
        pre { background: #f9f9f9; padding: 10px; border-radius: 4px; overflow-x: auto; max-height: 300px; }
    </style>
</head>
<body>

<h1>🔍 Payment Form & Cancel/Replace Functionality Debug</h1>

<div class="test-section success">
    <h2>✓ Step 1: Payment Form Debug</h2>
    <p><strong>What to check:</strong></p>
    <ol>
        <li>Go to <strong>checkout.php</strong></li>
        <li>Check browser DevTools (F12 → Console)</li>
        <li>Select payment method dropdown</li>
        <li>Watch for messages: "setupPaymentDetailsSection called" or errors</li>
        <li>Check if form divs appear:
            <ul>
                <li><code>card-details-group</code> (for Credit/Debit)</li>
                <li><code>upi-details-group</code> (for UPI)</li>
                <li><code>cod-details-group</code> (for COD)</li>
            </ul>
        </li>
    </ol>
</div>

<div class="test-section success">
    <h2>✓ Step 2: Cancel/Replace Button Debug</h2>
    <p><strong>What to check:</strong></p>
    <ol>
        <li>Place an order first (go to checkout and complete purchase)</li>
        <li>Go to <strong>order-tracking.php?id=YOUR_ORDER_ID</strong></li>
        <li>Click <strong>Cancel</strong> button on any item</li>
        <li>Enter a reason in the prompt dialog</li>
        <li>Watch the console (F12) for:
            <ul>
                <li>FormData being sent to <code>order_action_handler.php</code></li>
                <li>Response from server (should show success)</li>
                <li>Page should reload after 2 seconds</li>
            </ul>
        </li>
        <li>Check database:
            <ul>
                <li><code>order_items</code> table → status should be "Cancelled"</li>
                <li><code>cancellations</code> table → new record with reason</li>
            </ul>
        </li>
    </ol>
</div>

<div class="test-section warning">
    <h2>🔧 Quick Troubleshooting Commands</h2>
    <p>Run these in browser console (F12 → Console tab):</p>
    <pre>
// Check if setupPaymentDetailsSection exists
typeof setupPaymentDetailsSection

// Check if payment element exists
document.getElementById('payment')

// Check if card form exists
document.getElementById('card-details-group')

// Manually test payment form
setupPaymentDetailsSection()

// Check order action handler log
fetch('order_actions.log').then(r => r.text()).then(console.log)
    </pre>
</div>

<div class="test-section">
    <h2>📋 File Checks</h2>
    <?php
    $files = [
        'script.js' => 'setupPaymentDetailsSection function',
        'checkout.php' => 'card-details-group div',
        'order-tracking.php' => 'requestCancel function',
        'order_action_handler.php' => 'cancel action handler'
    ];

    foreach ($files as $file => $check) {
        $path = __DIR__ . '/' . $file;
        $exists = file_exists($path);
        $filesize = $exists ? filesize($path) : 0;
        $class = $exists ? 'success' : 'error';
        echo "<div class='file-check' style='padding:10px; background:#f9f9f9; border-radius:4px; margin:5px 0;'>";
        echo $exists ? '✓' : '✗';
        echo " <strong>$file</strong> - ";
        echo $exists ? "$filesize bytes" : "NOT FOUND";
        echo " (looking for: $check)";
        echo "</div>";
    }
    ?>
</div>

<div class="test-section">
    <h2>📝 Action Logs</h2>
    <?php
    if (file_exists('order_actions.log')) {
        $log = file_get_contents('order_actions.log');
        $lines = explode("\n", trim($log));
        $lastLines = array_slice($lines, -15);
        echo "<pre>" . htmlspecialchars(implode("\n", $lastLines)) . "</pre>";
    } else {
        echo "<p style='color:#999;'>No action log yet (will be created when cancel/replace is used)</p>";
    }
    ?>
</div>

<div class="test-section warning">
    <h2>⚡ Common Issues & Fixes</h2>
    <ul>
        <li>
            <strong>Payment form not showing:</strong>
            <ul>
                <li>Check browser console for JavaScript errors</li>
                <li>Verify <code>setupPaymentDetailsSection()</code> is called in renderCheckoutSummary()</li>
                <li>Make sure checkout.php has the payment divs with correct IDs</li>
            </ul>
        </li>
        <li>
            <strong>Cancel not saving to database:</strong>
            <ul>
                <li>Check order_actions.log file for database errors</li>
                <li>Verify <code>trackingOrderId</code> is not null in order-tracking.php</li>
                <li>Make sure order_id parameter is being sent to order_action_handler.php</li>
            </ul>
        </li>
        <li>
            <strong>Page not reloading after cancel:</strong>
            <ul>
                <li>Check if response is successful in browser console</li>
                <li>Check browser console for JavaScript errors in requestCancel function</li>
            </ul>
        </li>
    </ul>
</div>

</body>
</html>
