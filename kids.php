<?php
$page_title = "Kids' Collection | FASHIOFY";
include 'includes/header.php';
?>

<div class="page-banner"
        style="background-image: url('https://images.unsplash.com/photo-1519457439534-d14515607a75?w=1600&q=80');">
        <h1>KIDS COLLECTION</h1>
    </div>

    <section class="container section-padding">
        <div class="listing-container">
            <aside id="filter-sidebar" class="filter-sidebar"></aside>
            <div class="product-grid" id="category-product-grid" data-category="Kids">
                <!-- products will be injected by JavaScript -->
            </div>
        </div>
    </section>

<?php include 'includes/footer.php'; ?>
