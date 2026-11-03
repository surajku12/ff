<?php
if (function_exists('opcache_invalidate')) {
    opcache_invalidate(__FILE__, true);
}
$page_title = "Order Tracking | FASHIOFY";
include 'includes/header.php';
require_once 'includes/db.php';

$orderFound = false;
$order = null;
$items = [];
$trackingId = isset($_GET['id']) ? trim($_GET['id']) : '';
$isSuccess = isset($_GET['success']);
$isLocalMode = isset($_GET['local']) && $_GET['local'] === '1';

if ($trackingId && !$isLocalMode) {
    try {
        $stmt = $pdo->prepare("SELECT * FROM orders WHERE id = ?");
        $stmt->execute([$trackingId]);
        $order = $stmt->fetch();

        if ($order) {
            $orderFound = true;
            $itemsStmt = $pdo->prepare("SELECT * FROM order_items WHERE order_id = ?");
            $itemsStmt->execute([$trackingId]);
            $items = $itemsStmt->fetchAll();

            $itemStatuses = array_map(function($item) {
                return strtolower(trim($item['status'] ?? ''));
            }, $items);
            if (in_array('cancelled', $itemStatuses, true)) {
                $displayStatus = 'Cancelled';
            } elseif (in_array('replacement requested', $itemStatuses, true)) {
                $displayStatus = 'Replacement Requested';
            } else {
                $displayStatus = $order['status'];
            }
        }
    } catch (Exception $e) {
        $error = "Database Error: " . $e->getMessage();
    }
}
?>

<div class="tracking-hero" style="background: linear-gradient(rgba(0,0,0,0.8), rgba(0,0,0,0.8)), url('https://images.unsplash.com/photo-1555529733-0e670560f7e1?auto=format&fit=crop&q=80&w=2000') center/cover; color: white; padding: 100px 0; text-align: center;">
    <h1 style="font-family:'Playfair Display', serif; font-size: 3.5rem; margin-bottom: 15px;">Order Tracking</h1>
    <p style="opacity: 0.9; font-size: 1.1rem; letter-spacing: 1px;">Track your style journey in real-time</p>
</div>

<div class="tracking-container" style="max-width: 1000px; margin: -50px auto 100px; padding: 0 20px; position: relative; z-index: 10;">
    
    <!-- SEARCH ORDER -->
    <div class="track-section" style="background: white; padding: 40px; border-radius: 12px; box-shadow: 0 20px 40px rgba(0,0,0,0.05); margin-bottom: 40px;">
        <h3 style="font-size: 1.2rem; font-weight: 800; text-transform: uppercase; letter-spacing: 1px; margin-bottom: 25px; color: #111;">Track Your Parcel</h3>
        <form action="order-tracking.php" method="GET" style="display: flex; gap: 15px;">
            <input type="text" name="id" value="<?= htmlspecialchars($trackingId) ?>" placeholder="Enter Tracking ID (e.g., ORD-2026-XXXX)" 
                   style="flex: 1; padding: 18px; border: 2px solid #eee; border-radius: 8px; font-size: 1rem; outline: none; transition: border-color 0.3s ease;">
            <button type="submit" style="background: #111; color: white; border: none; padding: 0 35px; border-radius: 8px; font-weight: 700; text-transform: uppercase; letter-spacing: 1px; cursor: pointer; transition: all 0.3s ease;">Track Now</button>
        </form>
    </div>

    <div id="order-action-message" style="display:none; position: sticky; top: 20px; z-index: 50; background:#fff3cd; color:#856404; border:1px solid #ffeeba; border-radius:10px; padding:20px; margin-bottom:30px; font-weight:700; box-shadow: 0 8px 24px rgba(0,0,0,0.08);"></div>

    <!-- SUCCESS MESSAGE -->
    <?php if ($isLocalMode): ?>
    <div style="background: #d4edda; color: #155724; padding: 25px; border-radius: 8px; border-left: 5px solid #28a745; margin-bottom: 40px; display: flex; align-items: center; gap: 15px;">
        <div style="font-size: 1.8rem;">🎉</div>
        <div>
            <strong style="display: block; font-size: 1.1rem;">Order placed with offline mode!</strong>
            <span style="opacity: 0.9;">Your app is in local fallback mode. Order ID: <strong id="local-tracking-id"><?= htmlspecialchars($trackingId) ?></strong>.</span>
        </div>
    </div>
    <?php endif; ?>

    <?php if ($isSuccess && $orderFound): ?>
    <div style="background: #d4edda; color: #155724; padding: 25px; border-radius: 8px; border-left: 5px solid #28a745; margin-bottom: 40px; display: flex; align-items: center; gap: 15px;">
        <div style="font-size: 1.8rem;">🎉</div>
        <div>
            <strong style="display: block; font-size: 1.1rem;">Order Placed Successfully!</strong>
            <span style="opacity: 0.9;">Your Order ID is <strong><?= htmlspecialchars($trackingId) ?></strong>. Thank you for choosing FASHIOFY.</span>
        </div>
    </div>
    <?php endif; ?>

    <div id="local-order-output" style="background: white; padding: 40px; border-radius: 12px; box-shadow: 0 20px 40px rgba(0,0,0,0.05); margin-bottom: 40px; display: none;"></div>

    <?php if ($orderFound): ?>
    <!-- ORDER SUMMARY -->
    <div class="order-confirmation" style="background: white; padding: 50px; border-radius: 12px; box-shadow: 0 20px 40px rgba(0,0,0,0.05);">
        <div style="display: flex; justify-content: space-between; align-items: center; border-bottom: 1px solid #eee; padding-bottom: 30px; margin-bottom: 40px;">
            <div>
                <div style="font-size: 0.8rem; font-weight: 700; color: #888; text-transform: uppercase; margin-bottom: 5px;">Tracking Number</div>
                <div style="font-size: 1.5rem; font-weight: 900; color: #111;"><?= htmlspecialchars($order['id']) ?></div>
                <div style="font-size: 0.85rem; color: #666; margin-top: 5px;">Placed on <?= date('d M, Y', strtotime($order['created_at'])) ?></div>
            </div>
            <div style="background: #f8f9fa; padding: 12px 25px; border-radius: 50px; border: 1px solid #eee; font-weight: 800; text-transform: uppercase; font-size: 0.8rem; letter-spacing: 1px; color: #c5a059;">
                Status: <?= htmlspecialchars($displayStatus ?? $order['status']) ?>
            </div>
        </div>

        <div style="display: grid; grid-template-columns: 1.5fr 1fr; gap: 60px;">
            <div>
                <h4 style="font-size: 1.1rem; font-weight: 800; text-transform: uppercase; margin-bottom: 25px; color: #111; letter-spacing: 1px;">Items Details</h4>
                <div style="display: flex; flex-direction: column; gap: 20px;">
                    <?php foreach ($items as $item): ?>
                    <div style="display: flex; justify-content: space-between; align-items: center; padding: 15px; background: #fafafa; border-radius: 8px;">
                        <div>
                            <div style="font-weight: 800; font-size: 1rem; color: #111;"><?= htmlspecialchars($item['product_name']) ?></div>
                            <div style="font-size: 0.85rem; color: #777;">Size: <?= htmlspecialchars($item['size']) ?> | Qty: <?= htmlspecialchars($item['qty']) ?></div>
                        </div>
                        <div style="display: flex; flex-direction: column; align-items: flex-end; gap: 10px;">
                            <div style="font-weight: 800; color: #111;">₹<?= number_format($item['price'] * $item['qty'], 2) ?></div>
                            <?php if (!in_array(strtolower(trim($item['status'])), ['cancelled', 'replacement requested'])): ?>
                            <div style="display: flex; gap: 5px; flex-wrap: wrap;">
                                <button type="button" onclick='window.location.href = "order-action.php?action=cancel&order_id=" + encodeURIComponent(<?= json_encode($order['id']) ?>) + "&item_name=" + encodeURIComponent(<?= json_encode($item['product_name']) ?>);' style="padding: 5px 10px; background: #e74c3c; color: white; border: none; border-radius: 4px; font-size: 0.8rem; cursor: pointer;">Cancel</button>
                                <button type="button" onclick='window.location.href = "order-action.php?action=replacement&order_id=" + encodeURIComponent(<?= json_encode($order['id']) ?>) + "&item_name=" + encodeURIComponent(<?= json_encode($item['product_name']) ?>);' style="padding: 5px 10px; background: #f39c12; color: white; border: none; border-radius: 4px; font-size: 0.8rem; cursor: pointer;">Replace</button>
                            </div>
                            <?php else: ?>
                            <div style="font-size: 0.8rem; color: #666; font-weight: 600;"><?= htmlspecialchars($item['status']) ?></div>
                            <?php endif; ?>
                        </div>
                    </div>
                    <?php endforeach; ?>
                </div>

                <div style="margin-top: 40px; padding: 30px; background: #fdfaf4; border: 1px dashed #e3d2b2; border-radius: 8px;">
                    <h4 style="font-size: 0.9rem; font-weight: 800; text-transform: uppercase; margin-bottom: 15px;">Shipping Address</h4>
                    <p style="color: #666; line-height: 1.8; margin: 0;">
                        <strong><?= htmlspecialchars($order['name']) ?></strong><br>
                        <?= htmlspecialchars($order['street']) ?>, <?= htmlspecialchars($order['city']) ?><br>
                        <?= htmlspecialchars($order['state']) ?> - <?= htmlspecialchars($order['pincode']) ?><br>
                        Mobile: <?= htmlspecialchars($order['mobile']) ?>
                    </p>
                </div>
            </div>

            <div>
                <h4 style="font-size: 1.1rem; font-weight: 800; text-transform: uppercase; margin-bottom: 25px; color: #111; letter-spacing: 1px;">Payment Summary</h4>
                <div style="background: #fcfcfc; padding: 30px; border-radius: 8px; border: 1px solid #eee;">
                    <div style="display: flex; justify-content: space-between; margin-bottom: 15px; font-size: 0.9rem; color: #666;">
                        <span>Subtotal</span>
                        <span>₹<?= number_format($order['subtotal'], 2) ?></span>
                    </div>
                    <div style="display: flex; justify-content: space-between; margin-bottom: 15px; font-size: 0.9rem; color: #666;">
                        <span>GST (18%)</span>
                        <span>₹<?= number_format($order['tax'], 2) ?></span>
                    </div>
                    <div style="display: flex; justify-content: space-between; margin-bottom: 15px; font-size: 0.9rem; color: #666;">
                        <span>Shipping</span>
                        <span style="color: #2ecc71;">FREE</span>
                    </div>
                    <div style="display: flex; justify-content: space-between; margin-top: 20px; padding-top: 20px; border-top: 2px solid #111; font-weight: 900; font-size: 1.3rem; color: #111;">
                        <span>Total</span>
                        <span>₹<?= number_format($order['total'], 2) ?></span>
                    </div>
                    <div style="margin-top: 20px; font-size: 0.75rem; color: #999; text-align: center;">
                        Method: <?= htmlspecialchars($order['payment_method']) ?>
                    </div>
                </div>

                <div style="margin-top: 30px;">
                    <button onclick="window.print()" style="width: 100%; padding: 18px; border: 2px solid #111; background: transparent; color: #111; font-weight: 800; text-transform: uppercase; border-radius: 8px; cursor: pointer; transition: all 0.3s ease; margin-bottom: 15px;">Download Invoice</button>
                    <button onclick="window.location.href='index.php'" style="width: 100%; padding: 18px; background: #111; color: white; border: none; font-weight: 800; text-transform: uppercase; border-radius: 8px; cursor: pointer; transition: all 0.3s ease;">Back to Shopping</button>
                </div>
            </div>
        </div>

        <!-- TRACKING TIMELINE -->
        <div style="margin-top: 60px; padding-top: 60px; border-top: 1px solid #eee;">
            <h4 style="font-size: 1.1rem; font-weight: 800; text-transform: uppercase; margin-bottom: 40px; color: #111; letter-spacing: 1px; text-align: center;">Order Journey</h4>
            <div style="display: flex; justify-content: space-between; align-items: flex-start; max-width: 800px; margin: 0 auto; position: relative;">
                <!-- Timeline Line -->
                <div style="position: absolute; top: 15px; left: 0; right: 0; height: 3px; background: #eee; z-index: 1;"></div>
                
                <?php 
                if (isset($displayStatus) && strtolower($displayStatus) === 'cancelled') {
                    $statusSteps = ['Placed', 'Cancelled'];
                } elseif (isset($displayStatus) && strtolower($displayStatus) === 'replacement requested') {
                    $statusSteps = ['Placed', 'Replacement Requested'];
                } else {
                    $statusSteps = ['Placed', 'Confirmed', 'Shipped', 'Delivered'];
                }
                $currentStatusIndex = array_search($displayStatus ?? $order['status'], $statusSteps);
                if ($currentStatusIndex === false) $currentStatusIndex = 0;
                
                foreach ($statusSteps as $index => $step): 
                    $isCompleted = $index <= $currentStatusIndex;
                    $isActive = $index === $currentStatusIndex;
                    $color = $isCompleted ? '#111' : '#eee';
                    $dotContent = $isCompleted ? '✓' : '';
                ?>
                <div style="text-align: center; width: 80px; position: relative; z-index: 2;">
                    <div style="width: 34px; height: 34px; background: <?= $isActive ? '#c5a059' : ($isCompleted ? '#111' : 'white') ?>; border: 3px solid <?= $isCompleted ? ($isActive ? '#c5a059' : '#111') : '#eee' ?>; border-radius: 50%; margin: 0 auto 15px; display: flex; align-items: center; justify-content: center; color: white; font-weight: 900; font-size: 0.8rem;">
                        <?= $dotContent ?>
                    </div>
                    <div style="font-weight: <?= $isActive ? '800' : '600' ?>; font-size: 0.75rem; text-transform: uppercase; color: <?= $isActive ? '#111' : ($isCompleted ? '#555' : '#ccc') ?>; letter-spacing: 0.5px;"><?= $step ?></div>
                </div>
                <?php endforeach; ?>
            </div>
        </div>
    </div>

    <?php elseif ($isLocalMode): ?>
    <div id="local-order-summary" style="background: white; padding: 40px; border-radius: 12px; box-shadow: 0 20px 40px rgba(0,0,0,0.05);">
        <h2 style="font-family:'Playfair Display', serif; font-size: 2rem; margin-bottom: 15px;">Local-order tracking is active</h2>
        <div id="local-order-output" style="color:#555; font-size: 1rem;"></div>
        <p style="color: #888; margin-top: 20px;">Backend DB not required for this order thanks to offline fallback.</p>
    </div>
    <?php elseif ($trackingId): ?>
    <div style="background: white; padding: 60px; border-radius: 12px; box-shadow: 0 20px 40px rgba(0,0,0,0.05); text-align: center;">
        <div style="font-size: 4rem; margin-bottom: 20px;">🔍</div>
        <h2 style="font-family:'Playfair Display', serif; font-size: 2rem; margin-bottom: 10px;">Order Not Found</h2>
        <p style="color: #666; font-size: 1.1rem; margin-bottom: 30px;">We couldn't find any order with ID <strong><?= htmlspecialchars($trackingId) ?></strong>.<br>Please check the ID and try again.</p>
        <a href="order-tracking.php" style="display: inline-block; padding: 15px 40px; background: #111; color: white; text-decoration: none; border-radius: 8px; font-weight: 700; text-transform: uppercase; letter-spacing: 1px;">Try Again</a>
    </div>
    <?php else: ?>
    <!-- INITIAL VIEW -->
    <div style="background: white; padding: 60px; border-radius: 12px; box-shadow: 0 20px 40px rgba(0,0,0,0.05); text-align: center;">
        <div style="font-size: 4rem; margin-bottom: 20px;">📦</div>
        <h2 style="font-family:'Playfair Display', serif; font-size: 2rem; margin-bottom: 10px;">Where is my order?</h2>
        <p style="color: #666; font-size: 1.1rem; margin-bottom: 30px;">Enter your tracking ID above to see the status of your purchase.</p>
    </div>
    <?php endif; ?>
</div>

<style>
@media print {
    .tracking-hero, form, button, .tracking-container > div:first-child {
        display: none !important;
    }
    .tracking-container {
        margin: 0 !important;
        max-width: 100% !important;
        padding: 0 !important;
    }
    .order-confirmation {
        box-shadow: none !important;
        border: none !important;
        padding: 0 !important;
    }
}
</style>

<script>
    const trackingOrderId = <?= json_encode($orderFound ? $order['id'] : null) ?>;

    document.addEventListener('DOMContentLoaded', function () {
        const urlParams = new URLSearchParams(window.location.search);
        if (urlParams.get('local') !== '1') return;

        const trackingId = urlParams.get('id');
        const orders = JSON.parse(localStorage.getItem('FASHIOFY_orders') || '[]');
        const localOrder = orders.find(o => o.id === trackingId);
        if (!localOrder) return;

        const output = document.getElementById('local-order-output');
        if (!output) return;

        output.style.display = 'block';

        // Calculate dynamic status based on time
        const orderDate = new Date(localOrder.date);
        const now = new Date();
        const hoursSinceOrder = (now - orderDate) / (1000 * 60 * 60);

        let status = 'Placed';
        let statusColor = '#f39c12';
        if (hoursSinceOrder > 4) {
            status = 'Delivered';
            statusColor = '#27ae60';
        } else if (hoursSinceOrder > 2) {
            status = 'Shipped';
            statusColor = '#3498db';
        } else if (hoursSinceOrder > 1) {
            status = 'Confirmed';
            statusColor = '#e67e22';
        }

        let html = `<p><strong>Order ID:</strong> ${localOrder.id}</p>`;
        html += `<p><strong>Status:</strong> <span style="color: ${statusColor}; font-weight: bold;">${status}</span></p>`;
        html += `<p><strong>Name:</strong> ${localOrder.name || 'N/A'}</p>`;
        html += `<p><strong>Email:</strong> ${localOrder.email || 'N/A'}</p>`;
        html += `<p><strong>Mobile:</strong> ${localOrder.mobile || 'N/A'}</p>`;
        html += `<p><strong>Address:</strong> ${localOrder.street || ''}, ${localOrder.city || ''}, ${localOrder.state || ''} - ${localOrder.pincode || ''}</p>`;
        html += `<p><strong>Total:</strong> ₹${localOrder.total}</p>`;
        html += '<h4 style="margin-top:20px;">Ordered Items</h4>';
        localOrder.items.forEach(item => {
            html += `<div style="margin-bottom:10px;"><strong>${item.name}</strong> (size: ${item.size || 'N/A'}) x${item.qty} - ₹${item.price * item.qty}</div>`;
        });

        output.innerHTML = html;
    });

    function showOrderActionMessage(message) {
        const messageBox = document.getElementById('order-action-message');
        if (!messageBox) return;
        messageBox.innerHTML = `<span style="display:flex; align-items:center; gap:10px;"><strong>ℹ️</strong><span>${message}</span></span>`;
        messageBox.style.display = 'block';
        messageBox.scrollIntoView({ behavior: 'smooth', block: 'start' });
    }

    function requestCancel(itemName) {
        if (!trackingOrderId) {
            alert('Order ID missing. Please reload the page and try again.');
            return;
        }
        window.location.href = 'order-action.php?action=cancel&order_id=' + encodeURIComponent(trackingOrderId) + '&item_name=' + encodeURIComponent(itemName);
    }

    function requestReplacement(itemName) {
        if (!trackingOrderId) {
            alert('Order ID missing. Please reload the page and try again.');
            return;
        }
        window.location.href = 'order-action.php?action=replacement&order_id=' + encodeURIComponent(trackingOrderId) + '&item_name=' + encodeURIComponent(itemName);
    }
</script>

<?php include 'includes/footer.php'; ?>
