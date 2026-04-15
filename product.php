<?php
session_start();
require_once 'config/database.php';
require_once 'includes/functions.php';

$product_id = isset($_GET['id']) ? (int)$_GET['id'] : 0;

if ($product_id > 0) {
    $stmt = $pdo->prepare("SELECT * FROM products WHERE id = ?");
    $stmt->execute([$product_id]);
    $product = $stmt->fetch(PDO::FETCH_ASSOC);
} else {
    $product = null;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $product ? htmlspecialchars($product['name']) . ' - Gadget Hub' : 'Product Not Found - Gadget Hub' ?></title>
    <link rel="icon" type="image/x-icon" href="assets/images/favicon2.png">
    <link rel="stylesheet" href="assets/css/style.css">
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@700;900&family=DM+Sans:wght@300;400;500;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
</head>
<body>

<?php include 'includes/navbar.php'; ?>

<div class="container" style="max-width: 1200px; margin: 50px auto; padding: 0 20px;">
    <?php if ($product): ?>
        <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 40px; margin-bottom: 60px;">
            <!-- Product Image -->
            <div class="product-detail-image">
                <img src="<?= htmlspecialchars($product['image']) ?>" 
                     alt="<?= htmlspecialchars($product['name']) ?>"
                     style="width: 100%; border-radius: 12px; object-fit: cover; max-height: 500px;"
                     onerror="this.src='assets/images/placeholder.jpg'">
            </div>

            <!-- Product Details -->
            <div class="product-detail-info">
                <div style="margin-bottom: 12px;">
                    <span class="product-badge"><?= htmlspecialchars($product['category']) ?></span>
                </div>

                <h1 style="font-size: 2.2rem; font-weight: 700; margin-bottom: 16px; color: #222;">
                    <?= htmlspecialchars($product['name']) ?>
                </h1>

                <div class="product-rating" style="margin-bottom: 20px;">
                    <span class="stars" style="color: #f5a623; font-size: 1.1rem;">
                        ★★★★★ <?= number_format($product['rating'], 1) ?>
                    </span>
                    <span class="reviews" style="color: #888; margin-left: 10px;">
                        (<?= number_format($product['reviews']) ?> reviews)
                    </span>
                </div>

                <div style="border-top: 1px solid #eee; border-bottom: 1px solid #eee; padding: 20px 0; margin-bottom: 30px;">
                    <p style="color: #888; margin-bottom: 16px; line-height: 1.6;">
                        <?= htmlspecialchars($product['description']) ?>
                    </p>
                </div>

                <!-- Price Section -->
                <div style="margin-bottom: 30px;">
                    <p style="color: #888; font-size: 0.9rem; margin-bottom: 8px;">Price</p>
                    <h2 style="font-size: 2rem; color: #ff981f; font-weight: 700;">
                        Rs. <?= number_format($product['price'], 2) ?>
                    </h2>
                </div>

                <!-- Quantity Selector -->
                <div style="display: flex; gap: 20px; margin-bottom: 30px; align-items: center;">
                    <div class="qty-control" style="border: 1px solid #ddd; border-radius: 8px; padding: 8px 16px; display: flex; align-items: center;">
                        <button class="qty-btn" style="width: auto; height: auto; padding: 0 10px; border: none; background: none; cursor: pointer;" onclick="decreaseQty()">−</button>
                        <input type="number" id="quantity" value="1" min="1" max="100" style="width: 50px; text-align: center; border: none; outline: none; padding: 0 10px; font-size: 1rem;">
                        <button class="qty-btn" style="width: auto; height: auto; padding: 0 10px; border: none; background: none; cursor: pointer;" onclick="increaseQty()">+</button>
                    </div>
                </div>

                <!-- Add to Cart Button -->
                <button class="btn btn-dark" style="width: 100%; padding: 16px; font-size: 1.05rem; margin-bottom: 16px;" onclick="addToCart(<?= $product['id'] ?>)">
                    <i class="fas fa-shopping-cart"></i> Add to Cart
                </button>

                <!-- Back Button -->
                <a href="products.php" class="btn btn-outline" style="width: 100%; padding: 16px; text-align: center; font-size: 1.05rem; display: block;">
                     Back to Products
                </a>

                <!-- Gadget Specifications -->
                <div style="margin-top: 40px; padding-top: 30px; border-top: 1px solid #eee;">
                    <h3 style="font-size: 1.1rem; font-weight: 600; margin-bottom: 20px;">Gadget Specifications</h3>
                    <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 20px;">
                        <?php if (!empty($product['battery_life'])): ?>
                        <div>
                            <p style="font-size: 0.9rem; color: #272626; margin-bottom: 6px;">Battery Life</p>
                            <p style="font-weight: 600; font-size: 1rem;"><?= htmlspecialchars($product['battery_life']) ?></p>
                        </div>
                        <?php endif; ?>
                        
                        <?php if (!empty($product['warranty_years'])): ?>
                        <div>
                            <p style="font-size: 0.9rem; color: #191818; margin-bottom: 6px;">Warranty :</p>
                            <p style="font-weight: 600; font-size: 1rem;"><?= $product['warranty_years'] ?> Year(s)</p>
                        </div>
                        <?php endif; ?>
                        
                        <?php if (!empty($product['storage'])): ?>
                        <div>
                            <p style="font-size: 0.9rem; color: #888; margin-bottom: 6px;">Storage</p>
                            <p style="font-weight: 600; font-size: 1rem;"><?= htmlspecialchars($product['storage']) ?></p>
                        </div>
                        <?php endif; ?>
                        
                        <?php if (!empty($product['ram'])): ?>
                        <div>
                            <p style="font-size: 0.9rem; color: #888; margin-bottom: 6px;">RAM</p>
                            <p style="font-weight: 600; font-size: 1rem;"><?= htmlspecialchars($product['ram']) ?></p>
                        </div>
                        <?php endif; ?>
                        
                        <?php if (!empty($product['processor'])): ?>
                        <div>
                            <p style="font-size: 0.9rem; color: #888; margin-bottom: 6px;">Processor</p>
                            <p style="font-weight: 600; font-size: 1rem;"><?= htmlspecialchars($product['processor']) ?></p>
                        </div>
                        <?php endif; ?>
                        
                        <?php if (!empty($product['weight'])): ?>
                        <div>
                            <p style="font-size: 0.9rem; color: #888; margin-bottom: 6px;">Weight</p>
                            <p style="font-weight: 600; font-size: 1rem;"><?= htmlspecialchars($product['weight']) ?></p>
                        </div>
                        <?php endif; ?>
                        
                        <?php if (!empty($product['os'])): ?>
                        <div>
                            <p style="font-size: 0.9rem; color: #888; margin-bottom: 6px;">Operating System</p>
                            <p style="font-weight: 600; font-size: 1rem;"><?= htmlspecialchars($product['os']) ?></p>
                        </div>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>

        <!-- Related Products Section -->
        <section class="featured-section" style="margin-top: 60px; padding: 0;">
            <h2 class="section-title">More from <?= htmlspecialchars($product['category']) ?></h2>
            <p class="section-subtitle">Check out other products in this category</p>
            <div class="products-grid">
                <?php
                $stmt = $pdo->prepare("SELECT * FROM products WHERE category = ? AND id != ? LIMIT 4");
                $stmt->execute([$product['category'], $product['id']]);
                $related = $stmt->fetchAll(PDO::FETCH_ASSOC);
                
                if (count($related) > 0):
                    foreach ($related as $item):
                ?>
                    <div class="product-card">
                        <div class="product-badge"><?= htmlspecialchars($item['category']) ?></div>
                        <a href="product.php?id=<?= $item['id'] ?>">
                            <img src="<?= htmlspecialchars($item['image']) ?>"
                                 alt="<?= htmlspecialchars($item['name']) ?>"
                                 class="product-img"
                                 onerror="this.src='assets/images/placeholder.jpg'">
                        </a>
                        <div class="product-info">
                            <h3 class="product-name"><?= htmlspecialchars($item['name']) ?></h3>
                            <div class="product-rating">
                                <span class="stars">&#9733; <?= number_format($item['rating'], 1) ?></span>
                                <span class="reviews">(<?= number_format($item['reviews']) ?>)</span>
                            </div>
                            <p style="font-size:0.82rem;color:#888;margin-bottom:10px;">
                                <?= htmlspecialchars(substr($item['description'], 0, 80)) ?>...
                            </p>
                            <div class="product-footer">
                                <span class="product-price">Rs. <?= number_format($item['price'], 2) ?></span>
                                <button class="add-to-cart" onclick="addToCart(<?= $item['id'] ?>)">
                                    <i class="fas fa-shopping-cart"></i> Add
                                </button>
                            </div>
                        </div>
                    </div>
                <?php
                    endforeach;
                endif;
                ?>
            </div>
        </section>

    <?php else: ?>
        <div style="text-align: center; padding: 80px 20px;">
            <i class="fas fa-exclamation-triangle" style="font-size: 3rem; color: #ff981f; margin-bottom: 20px; display: block;"></i>
            <h2 style="font-size: 1.8rem; margin-bottom: 12px;">Product Not Found</h2>
            <p style="color: #888; margin-bottom: 30px;">The product you're looking for doesn't exist or has been removed.</p>
            <a href="products.php" class="btn btn-dark">Browse All Products</a>
        </div>
    <?php endif; ?>
</div>

<?php include 'includes/footer.php'; ?>

<script src="assets/js/main.js"></script>
<script>
function increaseQty() {
    const qty = document.getElementById('quantity');
    qty.value = parseInt(qty.value) + 1;
}

function decreaseQty() {
    const qty = document.getElementById('quantity');
    if (parseInt(qty.value) > 1) {
        qty.value = parseInt(qty.value) - 1;
    }
}
</script>
</body>
</html>
