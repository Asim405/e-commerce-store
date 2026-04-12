<?php
session_start();
require_once 'config/database.php';
require_once 'includes/functions.php';

$category = isset($_GET['category']) ? $_GET['category'] : 'All';
$products = getAllProducts($pdo, $category);

$categories = ['All', 'Audio', 'Wearables', 'Computers', 'Mobile', 'Photography', 'Tablets', 'Gaming'];
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Products - Tech Store</title>
    <link rel="icon" type="image/x-icon" href="assets/images/favicon2.png">
    <link rel="stylesheet" href="assets/css/style.css">
    <link href="https://fonts.googleapis.com/css2?family=DM+Sans:wght@300;400;500;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
</head>

<body>
    <?php include 'includes/navbar.php'; ?>

    <div class="featured-section">
        <h2 class="section-title">Our Products</h2>
        <p class="section-subtitle">Browse our complete collection of premium tech products</p>

        <!-- Category Filter -->
        <div class="category-filter">
            <?php foreach ($categories as $cat): ?>
                <a href="products.php?category=<?= $cat ?>"
                    class="filter-btn <?= $category === $cat ? 'active' : '' ?>">
                    <?= $cat ?>
                </a>
            <?php endforeach; ?>
        </div>

        <!-- Products Grid -->
        <div class="products-grid">
            <?php if (count($products) > 0): ?>
                <?php foreach ($products as $product): ?>
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
            <?php else: ?>
                <div style="grid-column:1/-1;text-align:center;padding:60px;color:#888;">
                    <i class="fas fa-box-open" style="font-size:3rem;margin-bottom:16px;display:block;"></i>
                    No products found in this category.
                </div>
            <?php endif; ?>
        </div>
    </div>

    <?php include 'includes/footer.php'; ?>
    <script src="assets/js/main.js"></script>
</body>

</html>