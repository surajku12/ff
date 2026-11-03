<?php
$page_title = "My Wishlist | FASHIOFY";
include 'includes/header.php';
?>

<div class="wishlist-hero" style="background: linear-gradient(rgba(0,0,0,0.7), rgba(0,0,0,0.7)), url('https://images.unsplash.com/photo-1441986300917-64674bd600d8?auto=format&fit=crop&q=80&w=2000') center/cover; color: white; padding: 100px 0; text-align: center;">
    <h1 style="font-family:'Playfair Display', serif; font-size: 3.5rem; margin-bottom: 15px;">My Wishlist</h1>
    <p style="opacity: 0.9; font-size: 1.1rem; letter-spacing: 1px;">Your personal collection of style inspirations</p>
</div>

<main class="wishlist-container" style="max-width: 1200px; margin: 0 auto; padding: 80px 20px;">
    <div id="wishlist-empty" class="wishlist-empty" style="display: none; text-align: center; padding: 100px 0;">
        <div style="font-size: 4rem; margin-bottom: 30px; opacity: 0.3;">🖤</div>
        <h2 style="font-family:'Playfair Display', serif; font-size: 2.5rem; margin-bottom: 20px;">Your wishlist is empty</h2>
        <p style="color: #666; font-size: 1.1rem; margin-bottom: 40px; max-width: 500px; margin-left: auto; margin-right: auto;">Explore our latest collections and save the pieces you love for later. Your perfect style is just a heart away.</p>
        <a href="index.php" class="btn" style="padding: 18px 45px; display: inline-block;">Start Exploring</a>
    </div>

    <div id="wishlist-content" class="wishlist-content" style="display: none;">
        <div class="wishlist-header" style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 50px; padding-bottom: 25px; border-bottom: 1px solid #eee;">
            <div>
                <h2 style="font-size: 1.5rem; font-weight: 800; text-transform: uppercase; letter-spacing: 1px; color: #111;">Saved Items (<span id="wishlist-count">0</span>)</h2>
            </div>
            <button class="clear-wishlist-btn" onclick="clearWishlist()" style="background: transparent; border: 1px solid #111; padding: 12px 25px; font-weight: 700; text-transform: uppercase; font-size: 0.75rem; letter-spacing: 1px; cursor: pointer; transition: all 0.3s ease;">Clear All Samples</button>
        </div>

        <div class="product-grid" id="wishlist-grid" style="display: grid; grid-template-columns: repeat(auto-fill, minmax(280px, 1fr)); gap: 40px;">
            <!-- items will be injected by script.js -->
        </div>
    </div>
</main>


<?php include 'includes/footer.php'; ?>
