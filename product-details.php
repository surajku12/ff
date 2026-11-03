<?php
$page_title = "Product Details | FASHIOFY";
include 'includes/header.php';
?>

<div class="container product-details-container" style="padding: 40px 20px;">
    <a href="index.php" class="back-button" style="text-decoration: none; color: #888; font-size: 0.9rem; margin-bottom: 20px; display: inline-block;">← Back to Collections</a>

    <main class="product-details" style="display: grid; grid-template-columns: 1fr 1fr; gap: 60px;">
        <div class="product-image-section" style="background: #fcfcfc; border-radius: 8px; overflow: hidden; display: flex; align-items: flex-start; justify-content: center; padding-top: 40px;">
            <img id="product-image" src="" alt="Product" style="max-width: 100%; max-height: 80vh; object-fit: contain; transition: transform 0.5s ease;">
        </div>

        <div class="product-info-section">
            <h1 id="product-name" style="font-size: 2.5rem; margin-bottom: 10px; font-family: 'Playfair Display', serif;">Loading...</h1>
            <p class="product-price" style="font-size: 2rem; font-weight: 800; color: #111; margin-bottom: 20px;">₹<span id="product-price">0.00</span></p>
            
            <p id="product-description" style="color: #666; font-size: 1rem; line-height: 1.8; margin-bottom: 40px; border-bottom: 1px solid #eee; padding-bottom: 30px;"></p>

            <div class="size-selection" style="margin-bottom: 40px;">
                <label style="display: block; margin-bottom: 15px; font-weight: 700; text-transform: uppercase; font-size: 0.8rem; letter-spacing: 1px; color: #111;">Select Your Size</label>
                <div id="size-options" style="display: flex; gap: 12px; flex-wrap: wrap;">
                    <!-- buttons injected by script.js -->
                </div>
                <!-- hidden select for compatibility with existing addToCartFromDetails -->
                <select id="size-select" style="display:none;"></select>
            </div>

            <div class="pincode-check" style="margin-bottom: 40px;">
                <label style="display: block; margin-bottom: 15px; font-weight: 700; text-transform: uppercase; font-size: 0.8rem; letter-spacing: 1px; color: #111;">Check Availability</label>
                <div style="display: flex; gap: 10px; align-items: center;">
                    <input type="text" id="pincode-input" placeholder="Enter Pincode" maxlength="6" style="padding: 12px; border: 2px solid #eee; border-radius: 4px; font-size: 1rem; width: 150px;">
                    <button onclick="checkStock()" style="padding: 12px 20px; background: #111; color: white; border: none; border-radius: 4px; font-weight: 700; cursor: pointer;">Check</button>
                </div>
                <div id="stock-status" style="margin-top: 10px; font-size: 0.9rem;"></div>
            </div>

            <div class="product-actions" style="display: flex; gap: 15px; margin-bottom: 40px;">
                <button class="btn-add-cart" onclick="addToCartFromDetails()" style="flex: 2; padding: 20px; background: #111; color: white; border: none; font-weight: 800; cursor: pointer; text-transform: uppercase; letter-spacing: 1px; transition: all 0.3s ease;">ADD TO BAG</button>
                <button class="btn-wishlist" id="wishlist-btn" onclick="addToWishlistFromDetails()" style="flex: 1; padding: 20px; background: white; border: 2px solid #111; color: #111; font-weight: 800; cursor: pointer; transition: all 0.3s ease;">❤️</button>
            </div>

            <!-- New Info Accordions -->
            <div class="product-info-accordions" style="margin-bottom: 50px; border-top: 1px solid #eee;">
                <div class="accordion-item" style="border-bottom: 1px solid #eee;">
                    <button class="accordion-header" onclick="toggleAccordion(this)" style="width: 100%; padding: 20px 0; background: none; border: none; display: flex; justify-content: space-between; align-items: center; cursor: pointer; text-transform: uppercase; font-weight: 700; font-size: 0.85rem; letter-spacing: 1px; color: #111;">
                        <span>Exclusive Offers</span>
                        <i class="fas fa-plus" style="font-size: 0.8rem; color: #999;"></i>
                    </button>
                    <div class="accordion-content" style="max-height: 0; overflow: hidden; transition: max-height 0.3s ease-out; background: #fdfdfd; padding: 0 20px;">
                        <ul style="padding: 15px 0 20px 20px; color: #666; font-size: 0.9rem; line-height: 1.8;">
                            <li>Get 10% instant discount on HDFC Bank Credit Cards.</li>
                            <li>Flat ₹500 Cashback on first purchase via FASHIOFY App.</li>
                            <li>Extra 5% off on orders above ₹5000.</li>
                        </ul>
                    </div>
                </div>

                <div class="accordion-item" style="border-bottom: 1px solid #eee;">
                    <button class="accordion-header" onclick="toggleAccordion(this)" style="width: 100%; padding: 20px 0; background: none; border: none; display: flex; justify-content: space-between; align-items: center; cursor: pointer; text-transform: uppercase; font-weight: 700; font-size: 0.85rem; letter-spacing: 1px; color: #111;">
                        <span>Available Discounts</span>
                        <i class="fas fa-plus" style="font-size: 0.8rem; color: #999;"></i>
                    </button>
                    <div class="accordion-content" style="max-height: 0; overflow: hidden; transition: max-height 0.3s ease-out; background: #fdfdfd; padding: 0 20px;">
                        <div style="padding: 15px 0 20px 0;">
                            <div style="background: #fff; border: 1.5px dashed #ddd; padding: 15px; margin-bottom: 15px; border-radius: 4px;">
                                <strong style="color: var(--accent); display: block; margin-bottom: 5px;">FIRST500</strong>
                                <span style="font-size: 0.85rem; color: #666;">Get ₹500 off on your first order. Minimum value ₹2999.</span>
                            </div>
                            <div style="background: #fff; border: 1.5px dashed #ddd; padding: 15px; border-radius: 4px;">
                                <strong style="color: var(--accent); display: block; margin-bottom: 5px;">FASHION15</strong>
                                <span style="font-size: 0.85rem; color: #666;">Flash Sale! Get 15% off on select collections today.</span>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="accordion-item" style="border-bottom: 1px solid #eee;">
                    <button class="accordion-header" onclick="toggleAccordion(this)" style="width: 100%; padding: 20px 0; background: none; border: none; display: flex; justify-content: space-between; align-items: center; cursor: pointer; text-transform: uppercase; font-weight: 700; font-size: 0.85rem; letter-spacing: 1px; color: #111;">
                        <span>Terms & Conditions</span>
                        <i class="fas fa-plus" style="font-size: 0.8rem; color: #999;"></i>
                    </button>
                    <div class="accordion-content" style="max-height: 0; overflow: hidden; transition: max-height 0.3s ease-out; background: #fdfdfd; padding: 0 20px;">
                        <p style="padding: 15px 0 20px 0; color: #666; font-size: 0.85rem; line-height: 1.8;">
                            All products are subject to availability. Prices are subject to change without notice. Standard 30-day return policy applies to unused items with original tags. Warranty is provided by the respective brand.
                        </p>
                    </div>
                </div>
            </div>

            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 20px; padding-top: 30px; border-top: 1px solid #eee;">
                <div style="display: flex; align-items: center; gap: 10px;">
                    <span style="font-size: 1.5rem;">🚚</span>
                    <div>
                        <h4 style="font-size: 0.8rem; text-transform: uppercase;">Free Shipping</h4>
                        <p style="font-size: 0.75rem; color: #888;">On orders over ₹1000</p>
                    </div>
                </div>
                <div style="display: flex; align-items: center; gap: 10px;">
                    <span style="font-size: 1.5rem;">🔄</span>
                    <div>
                        <h4 style="font-size: 0.8rem; text-transform: uppercase;">Easy Returns</h4>
                        <p style="font-size: 0.75rem; color: #888;">30-day effortless policy</p>
                    </div>
                </div>
            </div>
        </div>
    </main>

    <!-- Review / Comment Section -->
    <section class="product-reviews-section" style="margin-top: 80px; padding: 60px 0; border-top: 1px solid #eee;">
        <div style="display: grid; grid-template-columns: 1fr 1.5fr; gap: 60px;">
            <div class="review-form-container">
                <h2 style="font-family: 'Playfair Display', serif; font-size: 2rem; margin-bottom: 20px;">Customer Reviews</h2>
                <p style="color: #666; margin-bottom: 30px;">Share your experience with this product.</p>
                
                <?php if (isset($_SESSION['user_email'])): ?>
                <form id="review-form" style="background: #fdfdfd; padding: 30px; border-radius: 8px; border: 1px solid #eee;">
                    <div style="margin-bottom: 20px;">
                        <label style="display: block; font-weight: 700; margin-bottom: 10px; font-size: 0.8rem; text-transform: uppercase;">Rating</label>
                        <div class="star-rating" style="display: flex; gap: 5px; font-size: 1.5rem; color: #ddd; cursor: pointer;">
                            <span data-rating="1" class="star">★</span>
                            <span data-rating="2" class="star">★</span>
                            <span data-rating="3" class="star">★</span>
                            <span data-rating="4" class="star">★</span>
                            <span data-rating="5" class="star">★</span>
                        </div>
                        <input type="hidden" name="rating" id="review-rating" value="5">
                    </div>
                    <div style="margin-bottom: 20px;">
                        <label style="display: block; font-weight: 700; margin-bottom: 10px; font-size: 0.8rem; text-transform: uppercase;">Your Review</label>
                        <textarea name="comment" id="review-comment" placeholder="What did you like or dislike?" style="width: 100%; height: 120px; padding: 15px; border: 1px solid #ddd; border-radius: 4px; resize: none; font-family: inherit;"></textarea>
                    </div>
                    <button type="submit" style="width: 100%; padding: 15px; background: #111; color: white; border: none; font-weight: 800; cursor: pointer; text-transform: uppercase; letter-spacing: 1px;">Post Review</button>
                </form>
                <?php else: ?>
                <div style="background: #fff9f0; padding: 30px; border-radius: 8px; border: 1px solid #ffeeba; text-align: center;">
                    <p style="margin-bottom: 15px; font-weight: 600;">Please login to share your feedback.</p>
                    <a href="login.php?redirect=<?php echo urlencode(basename($_SERVER['PHP_SELF']) . '?' . $_SERVER['QUERY_STRING']); ?>" class="btn-outline" style="text-decoration: none;">Login Now</a>
                </div>
                <?php endif; ?>
            </div>

            <div class="reviews-display">
                <div id="reviews-list" style="display: flex; flex-direction: column; gap: 30px;">
                    <!-- reviews injected by JS -->
                    <p style="color: #999; font-style: italic;">Loading reviews...</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Recommendations -->
    <section style="margin-top: 100px; padding-top: 60px; border-top: 1px solid #eee;">
        <h2 style="font-family: 'Playfair Display', serif; font-size: 2.2rem; margin-bottom: 40px; text-align: center;">Recommended Collections</h2>
        <div id="related-product-grid" class="product-grid" style="display: grid; grid-template-columns: repeat(auto-fit, minmax(250px, 1fr)); gap: 30px;">
            <!-- related products -->
        </div>
    </section>

    <!-- Recently Viewed -->
    <section id="recent-views-section" style="margin-top: 100px; padding-top: 60px; border-top: 1px solid #eee; display: none;">
        <h2 style="font-family: 'Playfair Display', serif; font-size: 2.2rem; margin-bottom: 40px; text-align: center;">Recently Viewed Items</h2>
        <div id="recently-viewed-grid" class="product-grid" style="display: grid; grid-template-columns: repeat(auto-fit, minmax(250px, 1fr)); gap: 30px;">
            <!-- recently viewed -->
        </div>
    </section>
</div>

<?php include 'includes/footer.php'; ?>
