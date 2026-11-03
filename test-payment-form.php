<?php
session_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Payment Form Testing Guide</title>
    <style>
        body { font-family: Arial, sans-serif; margin: 20px; background: #f5f5f5; }
        .container { max-width: 900px; margin: 0 auto; background: white; padding: 30px; border-radius: 8px; }
        h1 { color: #111; border-bottom: 3px solid #111; padding-bottom: 10px; }
        .test-step { margin: 20px 0; padding: 15px; background: #e8f5e9; border-left: 4px solid #27ae60; }
        .code { background: #f0f0f0; padding: 10px; border-radius: 4px; font-family: monospace; margin: 5px 0; }
        button { background: #111; color: white; padding: 12px 20px; border: none; border-radius: 4px; cursor: pointer; }
        button:hover { background: #333; }
        .success { color: #27ae60; font-weight: bold; }
        .error { color: #e74c3c; font-weight: bold; }
        .log-section { background: #f0f0f0; padding: 15px; border-radius: 4px; margin-top: 20px; }
        .log-section h3 { margin-top: 0; }
        .log-item { padding: 8px; background: white; margin: 5px 0; border-left: 3px solid #2196F3; font-family: monospace; font-size: 0.9em; }
    </style>
</head>
<body>
    <div class="container">
        <h1>🧪 Payment Form & Cancel/Replace Button Testing</h1>

        <h2>📋 Quick Checklist</h2>
        <div style="background: #fff3cd; padding: 15px; border-radius: 4px; margin-bottom: 20px;">
            <p><strong>Before testing:</strong> Open Developer Tools (F12) and go to the Console tab. This will show if setupPaymentDetailsSection() is being called.</p>
        </div>

        <h2>✅ Test 1: Payment Form Selection</h2>
        <div class="test-step">
            <h3>Steps:</h3>
            <ol>
                <li>Go to <a href="http://localhost/kash/checkout.php" target="_blank"><strong>checkout.php</strong></a></li>
                <li>Scroll down to "Payment Method"</li>
                <li>Open DevTools (F12) → Console tab</li>
                <li>Select "Credit Card" from the dropdown</li>
                <li>Check if:</li>
                <ul>
                    <li>Console shows: <span class="code">"setupPaymentDetailsSection() called"</span></li>
                    <li>Console shows: <span class="code">"Payment method changed to: credit-card"</span></li>
                    <li>Card form (Cardholder Name, Card Number, etc.) appears below the dropdown</li>
                </ul>
            </ol>
        </div>

        <h2>✅ Test 2: UPI Form & QR Code</h2>
        <div class="test-step">
            <h3>Steps:</h3>
            <ol>
                <li>On the same checkout page, select "UPI / Scanner" from dropdown</li>
                <li>Verify:</li>
                <ul>
                    <li>Console shows: <span class="code">"Payment method changed to: upi"</span></li>
                    <li>Card form disappears</li>
                    <li>UPI form appears with "UPI ID" input</li>
                    <li>A box appears with "Scan with Your UPI App"</li>
                </ul>
                <li>Enter a UPI ID like: <span class="code">test@upi</span></li>
                <li>A QR code should appear in the box below</li>
            </ol>
        </div>

        <h2>✅ Test 3: Cancel/Replace Button</h2>
        <div class="test-step">
            <h3>Prerequisites:</h3>
            <ol>
                <li>You must have placed at least one order</li>
                <li>Note your order ID from the order history</li>
            </ol>
            <h3>Steps:</h3>
            <ol>
                <li>Go to <a href="http://localhost/kash/order-tracking.php" target="_blank"><strong>order-tracking.php</strong></a></li>
                <li>Enter your order ID in the search box</li>
                <li>Click on a product and find the "Cancel" or "Replace" button</li>
                <li>Click "Cancel"</li>
                <li>A prompt should ask: "Please provide a reason for cancellation"</li>
                <li>Enter a reason (e.g., "Changed my mind")</li>
                <li>Open DevTools (F12) → Console to see the request</li>
                <li>Check phpMyAdmin → fashiofy database → Order_items/cancellations tables to verify data was saved</li>
            </ol>
        </div>

        <h2>🔍 Debugging Info</h2>
        <div class="test-step">
            <h3>If Payment Form Doesn't Appear:</h3>
            <ul>
                <li>Check console for error: <span class="error">"payment field not found"</span></li>
                <li>Make sure the checkout form has <span class="code">id="payment"</span> dropdown</li>
                <li>Check that setupPaymentDetailsSection() is called (should see console message)</li>
                <li>Try refreshing the page and selecting payment method again</li>
            </ul>

            <h3>If Cancel/Replace Doesn't Work:</h3>
            <ul>
                <li>Check file: <span class="code">order_actions.log</span> in your kash folder root</li>
                <li>This log will show if the request reached the server and what errors occurred</li>
                <li>Verify order_id is being passed correctly from order-tracking.php</li>
                <li>Check that cancellations table exists in your database</li>
            </ul>
        </div>

        <h2>📁 Log Files to Check</h2>
        <div class="test-step">
            <h3>Check these files in <span class="code">c:\xampp\htdocs\kash\</span>:</h3>
            <ul>
                <li><span class="code">order_actions.log</span> - Shows cancel/replace attempts and errors</li>
                <li><span class="code">checkout_orders.log</span> - Shows order placement attempts</li>
            </ul>
            <p><strong>To view:</strong> Right-click file → Open with Notepad, or use FileZilla/FTP</p>
        </div>

        <h2>🗄️ Database Check</h2>
        <div class="test-step">
            <h3>In phpMyAdmin, verify these tables exist in "fashiofy" database:</h3>
            <ul>
                <li>users</li>
                <li>login_logs</li>
                <li>orders</li>
                <li>order_items</li>
                <li>cancellations</li>
            </ul>
            <p>After clicking Cancel, check the <span class="code">order_items</span> table → status should change to "Cancelled"</p>
        </div>

        <h2>⚠️ Common Issues & Solutions</h2>
        <table style="width: 100%; border-collapse: collapse;">
            <tr style="background: #e8e8e8;">
                <th style="padding: 10px; text-align: left; border: 1px solid #ddd;">Issue</th>
                <th style="padding: 10px; text-align: left; border: 1px solid #ddd;">Solution</th>
            </tr>
            <tr>
                <td style="padding: 10px; border: 1px solid #ddd;">Payment form doesn't appear</td>
                <td style="padding: 10px; border: 1px solid #ddd;">Hard refresh page (Ctrl+F5), check console for setupPaymentDetailsSection logs</td>
            </tr>
            <tr style="background: #f9f9f9;">
                <td style="padding: 10px; border: 1px solid #ddd;">QR code doesn't generate</td>
                <td style="padding: 10px; border: 1px solid #ddd;">Make sure UPI ID is valid format (e.g., test@upi), check if api.qrserver.com is accessible</td>
            </tr>
            <tr>
                <td style="padding: 10px; border: 1px solid #ddd;">Cancel button does nothing</td>
                <td style="padding: 10px; border: 1px solid #ddd;">Check order_actions.log for server errors, verify order_id is passed correctly</td>
            </tr>
            <tr style="background: #f9f9f9;">
                <td style="padding: 10px; border: 1px solid #ddd;">No response from cancel request</td>
                <td style="padding: 10px; border: 1px solid #ddd;">Check if order_action_handler.php exists and has correct database connection</td>
            </tr>
        </table>

        <h2>✨ Next Steps</h2>
        <div style="background: #e3f2fd; padding: 15px; border-radius: 4px; margin-top: 20px;">
            <ol>
                <li><strong>Test payment form</strong> by going to checkout and selecting each payment method</li>
                <li><strong>Check console logs</strong> to ensure setupPaymentDetailsSection() is being called</li>
                <li><strong>Test cancel/replace</strong> if you have placed an order</li>
                <li><strong>Share any console errors</strong> or log file contents if something doesn't work</li>
            </ol>
        </div>

        <button onclick="window.open('http://localhost/kash/checkout.php', '_blank')">Open Checkout Page</button>
        <button onclick="window.open('http://localhost/kash/order-tracking.php', '_blank')">Open Order Tracking</button>
        <button onclick="alert('To view logs:\n1. Go to c:\\xampp\\htdocs\\kash\\\n2. Look for order_actions.log and checkout_orders.log\n3. Open with Notepad'); return false;">View Log Instructions</button>
    </div>
</body>
</html>
