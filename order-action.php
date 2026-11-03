<?php
if (function_exists('opcache_invalidate')) {
    opcache_invalidate(__FILE__, true);
}
$page_title = "Order Action | FASHIOFY";
include 'includes/header.php';
require_once 'includes/db.php';

$action = isset($_GET['action']) ? trim($_GET['action']) : '';
$orderId = isset($_GET['order_id']) ? trim($_GET['order_id']) : '';
$itemName = isset($_GET['item_name']) ? trim($_GET['item_name']) : '';

$allowedActions = ['cancel' => 'Cancel', 'replacement' => 'Replace'];
$actionLabel = $allowedActions[$action] ?? null;
$errorMessage = '';
$order = null;
$item = null;

if (!$actionLabel || !$orderId || !$itemName) {
    $errorMessage = 'Invalid action or missing order/item information.';
} else {
    try {
        $stmt = $pdo->prepare("SELECT * FROM orders WHERE id = ?");
        $stmt->execute([$orderId]);
        $order = $stmt->fetch();

        if (!$order) {
            $errorMessage = 'Order not found. Please return to the tracking page and try again.';
        } else {
            $stmt = $pdo->prepare("SELECT * FROM order_items WHERE order_id = ? AND product_name = ?");
            $stmt->execute([$orderId, $itemName]);
            $item = $stmt->fetch();

            if (!$item) {
                $errorMessage = 'Item not found in this order. Please return to the tracking page and try again.';
            } elseif ($item['status'] !== 'Active') {
                $errorMessage = 'This item cannot be modified because its current status is: ' . htmlspecialchars($item['status']) . '.';
            }
        }
    } catch (Exception $e) {
        $errorMessage = 'Database error: ' . $e->getMessage();
    }
}

$reasonOptions = [];
if ($action === 'cancel') {
    $reasonOptions = [
        'Changed my mind',
        'Found a better price elsewhere',
        'Shipping is taking too long',
        'Ordered the wrong item by mistake',
    ];
} elseif ($action === 'replacement') {
    $reasonOptions = [
        'Wrong size',
        'Defective or damaged item',
        'Color/style does not match expectations',
        'Missing part or accessory',
    ];
}
?>

<div class="tracking-hero" style="background: linear-gradient(rgba(0,0,0,0.8), rgba(0,0,0,0.8)), url('https://images.unsplash.com/photo-1555529733-0e670560f7e1?auto=format&fit=crop&q=80&w=2000') center/cover; color: white; padding: 100px 0; text-align: center;">
    <h1 style="font-family:'Playfair Display', serif; font-size: 3.5rem; margin-bottom: 15px;">Order <?= $actionLabel ?> Request</h1>
    <p style="opacity: 0.9; font-size: 1.1rem; letter-spacing: 1px;">Provide a reason for your <?= strtolower($actionLabel) ?> request below.</p>
</div>

<div class="tracking-container" style="max-width: 760px; margin: -50px auto 100px; padding: 0 20px; position: relative; z-index: 10;">
    <div style="background: white; padding: 40px; border-radius: 12px; box-shadow: 0 20px 40px rgba(0,0,0,0.05);">
        <?php if ($errorMessage): ?>
            <div style="background: #fdecea; color: #611a15; padding: 25px; border-radius: 10px; border: 1px solid #f5c6cb; margin-bottom: 20px;">
                <strong>Error:</strong> <?= htmlspecialchars($errorMessage) ?>
            </div>
            <a href="order-tracking.php?id=<?= urlencode($orderId) ?>" style="display: inline-block; padding: 14px 28px; background: #111; color: white; border-radius: 8px; text-decoration: none;">Return to Order Tracking</a>
        <?php else: ?>
            <div style="display: grid; gap: 30px;">
                <div style="display: flex; justify-content: space-between; align-items: flex-start; gap: 20px; flex-wrap: wrap;">
                    <div style="flex: 1; min-width: 230px;">
                        <div style="font-size: 0.9rem; color: #888; text-transform: uppercase; letter-spacing: 1px; margin-bottom: 10px;">Order</div>
                        <div style="font-size: 1.25rem; font-weight: 900; color: #111;"><?= htmlspecialchars($order['id']) ?></div>
                        <div style="margin-top: 8px; color: #666;">Placed on <?= date('d M, Y', strtotime($order['created_at'])) ?></div>
                    </div>
                    <div style="background: #f8f9fa; padding: 18px 22px; border-radius: 12px; border: 1px solid #eee; min-width: 210px;">
                        <div style="font-size: 0.8rem; color: #888; text-transform: uppercase; letter-spacing: 1px; margin-bottom: 8px;">Action</div>
                        <div style="font-size: 1.1rem; font-weight: 800; color: #111;"><?= $actionLabel ?></div>
                    </div>
                </div>

                <div style="background: #fbfbfb; padding: 25px; border-radius: 12px; border: 1px solid #eee;">
                    <h2 style="font-size: 1.15rem; font-weight: 800; margin-bottom: 18px;">Item</h2>
                    <p style="margin:0; font-size: 1rem; color: #111;"><strong><?= htmlspecialchars($item['product_name']) ?></strong></p>
                    <p style="margin: 8px 0 0; color: #666;">Size: <?= htmlspecialchars($item['size']) ?> | Qty: <?= htmlspecialchars($item['qty']) ?></p>
                </div>

                <form id="order-action-form" style="display: grid; gap: 20px;">
                    <input type="hidden" name="action" value="<?= htmlspecialchars($action) ?>">
                    <input type="hidden" name="order_id" value="<?= htmlspecialchars($orderId) ?>">
                    <input type="hidden" name="item_name" value="<?= htmlspecialchars($itemName) ?>">

                    <div>
                        <div style="font-size: 0.95rem; font-weight: 800; margin-bottom: 10px; color: #111;">Choose a reason</div>
                        <div style="display: grid; gap: 10px;">
                            <?php foreach ($reasonOptions as $index => $option): ?>
                                <label style="display: flex; align-items: center; gap: 12px; background: #fafafa; padding: 14px 16px; border: 1px solid #e5e5e5; border-radius: 10px; cursor: pointer;">
                                    <input type="radio" name="reason_option" value="<?= htmlspecialchars($option) ?>" style="accent-color: #c5a059;">
                                    <span style="color: #333;"><?= htmlspecialchars($option) ?></span>
                                </label>
                            <?php endforeach; ?>
                        </div>
                    </div>

                    <div>
                        <label for="reason_text" style="display:block; font-size:0.95rem; font-weight:800; margin-bottom:10px; color:#111;">Or write your own reason</label>
                        <textarea id="reason_text" name="reason_text" rows="5" placeholder="Type your reason here..." style="width:100%; padding:16px; border:1px solid #ddd; border-radius:10px; resize:vertical; font-size:0.95rem; line-height:1.5;"></textarea>
                    </div>

                    <div id="action-response" style="display:none; padding: 18px; border-radius: 12px; font-weight:700;"></div>

                    <div style="display:flex; flex-wrap:wrap; gap: 12px;">
                        <button type="submit" style="background: #111; color: white; border:none; padding: 15px 28px; border-radius: 10px; font-size: 0.95rem; cursor:pointer;">Submit <?= $actionLabel ?> Request</button>
                        <a href="order-tracking.php?id=<?= urlencode($orderId) ?>" style="display:inline-flex; align-items:center; justify-content:center; padding: 15px 28px; border-radius: 10px; border: 1px solid #111; color: #111; text-decoration:none;">Back to Tracking</a>
                    </div>
                </form>
            </div>
        <?php endif; ?>
    </div>
</div>

<script>
    const form = document.getElementById('order-action-form');
    if (form) {
        form.addEventListener('submit', function(event) {
            event.preventDefault();
            const selectedOption = form.querySelector('input[name="reason_option"]:checked');
            const customReason = document.getElementById('reason_text').value.trim();
            const responseBox = document.getElementById('action-response');

            let reason = '';
            if (customReason) {
                reason = customReason;
            } else if (selectedOption) {
                reason = selectedOption.value;
            }

            if (!reason) {
                responseBox.style.display = 'block';
                responseBox.style.background = '#fff3cd';
                responseBox.style.color = '#856404';
                responseBox.style.border = '1px solid #ffeeba';
                responseBox.textContent = 'Please choose a reason or write your own before submitting.';
                return;
            }

            const data = new FormData(form);
            data.set('reason', reason);

            fetch('order_action_handler.php', {
                method: 'POST',
                body: data
            })
            .then(response => response.json())
            .then(result => {
                if (result.success) {
                    responseBox.style.display = 'block';
                    responseBox.style.background = '#d4edda';
                    responseBox.style.color = '#155724';
                    responseBox.style.border = '1px solid #c3e6cb';
                    responseBox.textContent = result.message || 'Your request has been submitted successfully.';
                    setTimeout(() => {
                        window.location.href = 'order-tracking.php?id=' + encodeURIComponent(<?= json_encode($orderId) ?>);
                    }, 2200);
                } else {
                    responseBox.style.display = 'block';
                    responseBox.style.background = '#fdecea';
                    responseBox.style.color = '#611a15';
                    responseBox.style.border = '1px solid #f5c6cb';
                    responseBox.textContent = result.message || 'Unable to submit your request. Please try again.';
                }
            })
            .catch(() => {
                responseBox.style.display = 'block';
                responseBox.style.background = '#fdecea';
                responseBox.style.color = '#611a15';
                responseBox.style.border = '1px solid #f5c6cb';
                responseBox.textContent = 'Unable to submit your request. Please try again later.';
            });
        });
    }
</script>

<?php include 'includes/footer.php'; ?>
