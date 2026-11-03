<?php
$page_title = "Men's Collection | FASHIOFY";
include 'includes/header.php';
?>

<div class="page-banner"
        style="background-image: url('https://images.unsplash.com/photo-1490578474895-699cd4e2cf59?w=1600&q=80');">
        <h1>MEN'S ESSENTIALS</h1>
    </div>

    <section class="container section-padding">
        <div class="listing-container">
            <aside id="filter-sidebar" class="filter-sidebar"></aside>
            <div class="product-grid" id="category-product-grid" data-category="Men">
                <!-- products will be injected by JavaScript -->
            </div>
        </div>
    </section>

<?php include 'includes/footer.php'; ?>
