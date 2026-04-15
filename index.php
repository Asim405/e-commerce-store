<?php
session_start();
require_once 'config/database.php';
require_once 'includes/functions.php';

$featured_products = getFeaturedProducts($pdo, 4);
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gadget Hub</title>

    <link rel="icon" type="image/x-icon" href="assets/images/favicon2.png">
    <link rel="stylesheet" href="assets/css/style.css">
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@700;900&family=DM+Sans:wght@300;400;500;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
</head>

<body>

    <?php include 'includes/navbar.php'; ?>

    <!-- Hero -->
    <section class="hero">
        <div class="hero-content">
            <h1 class="hero-title">Welcome to Gadget Hub</h1>
            <p class="hero-subtitle">
                Discover the latest tech products at unbeatable prices.<br>
                Premium quality, fast shipping, and exceptional customer service.
            </p>
            <div class="hero-buttons">
                <a href="products.php" class="btn btn-dark">Shop Now &rarr;</a>
                <a href="about.php" class="btn btn-outline">Learn More</a>
            </div>
        </div>
    </section>

    <!-- Featured Products -->
    <section class="featured-section">
        <h2 class="section-title">Featured Products</h2>
        <p class="section-subtitle">Check out our most popular products</p>
        <div class="products-grid">
            <?php foreach ($featured_products as $product): ?>
                <div class="product-card">
                    <div class="product-badge"><?= htmlspecialchars($product['category']) ?></div>
                    <a href="product.php?id=<?= $product['id'] ?>">
                        <img src="<?= htmlspecialchars($product['image']) ?>"
                            alt="<?= htmlspecialchars($product['name']) ?>"
                            class="product-img"
                            onerror="this.src='assets/images/placeholder.jpg'">
                    </a>
                    <div class="product-info">
                        <h3 class="product-name"><?= htmlspecialchars($product['name']) ?></h3>
                        <div class="product-rating">
                            <span class="stars">&#9733; <?= number_format($product['rating'], 1) ?></span>
                            <span class="reviews">(<?= number_format($product['reviews']) ?>)</span>
                        </div>
                        <p style="font-size:0.82rem;color:#888;margin-bottom:10px;">
                            <?= htmlspecialchars($product['description']) ?>
                        </p>
                        <div class="product-footer">
                            <span class="product-price">Rs. <?= number_format($product['price'], 2) ?></span>
                            <button class="add-to-cart" onclick="addToCart(<?= $product['id'] ?>)">
                                <i class="fas fa-shopping-cart"></i> Add
                            </button>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
        <div class="view-all">
            <a href="products.php" class="btn btn-dark">View All Products &rarr;</a>
        </div>
    </section>

    <?php include 'includes/footer.php'; ?>
    <script src="assets/js/main.js"></script>
</body>

</html>