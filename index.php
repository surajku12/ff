<?php
$page_title = "Home Page | FASHIOFY";
include 'includes/header.php';
?>

<main>
        <section class="hero-split">
            <div class="hero-content">
                <span class="tagline">Summer Collection 2026</span>
                <h1>ELEVATE YOUR <br>DAILY LOOK.</h1>
                <p style="margin-bottom: 30px; color: #555;">High-quality western wear designed for durability and
                    comfort. Curated for the modern creator.</p>
                <a href="men.php" class="btn">Shop Now</a>
            </div>
            <div class="hero-image-box">
                <img src="images/QUILTED JACQUARD JACKET FORD.jpg" alt="Fashion Model">
            </div>
        </section>

        <!-- ORDER TRACKING BANNER -->
        <section
            style="background: linear-gradient(135deg, #f9f9f9 0%, #f0f0f0 100%); padding: 60px 20px; margin: 60px 0;">
            <div class="container">
                <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 40px; align-items: center;">
                    <div>
                        <h2
                            style="font-family: 'Playfair Display', serif; font-size: 2rem; margin-bottom: 15px; color: #111;">
                            Track Your Order
                        </h2>
                        <p style="color: #555; line-height: 1.8; margin-bottom: 25px;">
                            Monitor your purchase in real-time. Know exactly when your order arrives with our advanced
                            tracking system.
                        </p>
                        <a href="order-tracking.php" class="btn" style="display: inline-block;">📦 View Tracking</a>
                    </div>
                    <div
                        style="background: white; padding: 30px; border-radius: 8px; box-shadow: 0 4px 15px rgba(0,0,0,0.1);">
                        <div style="text-align: center; margin-bottom: 20px; font-size: 2.5rem;">📊</div>
                        <div style="text-align: center; margin-bottom: 15px;">
                            <strong style="color: #111; font-size: 1.1rem;">Real-Time Updates</strong>
                            <p style="color: #999; font-size: 0.9rem; margin-top: 8px;">Order Placed • Confirmed •
                                Shipped • Out for Delivery • Delivered</p>
                        </div>
                        <div style="text-align: center; padding: 15px; background: #f0f8ff; border-radius: 4px;">
                            <span style="color: #0066cc; font-weight: 600; font-size: 0.9rem;">Expected Delivery in 5
                                Days</span>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <section class="container section-padding">
            <div class="text-center">
                <span class="tagline">Curated Selection</span>
                <h2 style="font-family: 'Playfair Display', serif; font-size: 2.5rem;">The Western Edit</h2>
            </div>

            <div id="category-filters" style="display:flex; flex-wrap:wrap; gap:10px; justify-content:center; margin-bottom:20px;"></div>

            <div class="product-grid" id="home-product-grid">
                <!-- products will be injected by JavaScript -->
            </div>
        </section>
    </main>

<?php include 'includes/footer.php'; ?>
