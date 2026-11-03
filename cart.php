<?php
$page_title = "Shopping Bag | FASHIOFY";
include 'includes/header.php';
?>

<div class="cart-hero">
        <h1>Your Shopping Bag</h1>
        <p>Review or remove items before checkout.</p>
        <div style="margin-top: 20px;">
            <a href="order-tracking.php" style="color: #c5a059; text-decoration: none; font-weight: 600;">📦 Track Your
                Order</a>
        </div>
    </div>
    <main class="cart-container">
        <div id="cart-empty" class="cart-empty" style="display:none;">
            <h2>Your bag is empty</h2>
            <p>Add products to your bag and they will appear here.</p>
            <a href="index.php" class="btn">Continue Shopping</a>
        </div>
        <div id="cart-content" class="cart-content" style="display:none;">
            <div class="cart-stats">
                <span class="cart-stats-text"><strong id="cart-count-display">0</strong> items in your bag</span>
                <button class="clear-wishlist-btn" onclick="clearCart()">Clear Bag</button>
            </div>
            <div class="cart-grid" id="cart-grid"></div>
            <div class="cart-summary" id="cart-summary"></div>
            <button class="btn-checkout" onclick="checkout()">Proceed to Checkout</button>
        </div>
    </main>

<?php include 'includes/footer.php'; ?>
