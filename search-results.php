<?php
$page_title = "Search Results | FASHIOFY";
include 'includes/header.php';
?>

    <div class="results-hero">
        <div class="container">
            <form onsubmit="onSearchSubmit(event)" style="display:flex; gap:12px; align-items:center;">
                <input id="results-search" class="search-bar" placeholder="Search products by name...">
                <button class="btn btn-small" type="submit">Search</button>
                <a href="index.php" class="btn" style="margin-left:auto;">Back Home</a>
            </form>
        </div>
    </div>

    <main class="container section-padding">
        <div id="results-count" class="results-count" style="margin-bottom: 20px; font-weight: 700;"></div>
        <div class="listing-container">
            <aside id="filter-sidebar" class="filter-sidebar"></aside>
            <div id="results-list" class="product-grid"></div>
        </div>
    </main>

<?php include 'includes/footer.php'; ?>
