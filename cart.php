<?php
session_start();
require_once 'config/database.php';
require_once 'includes/functions.php';

$session_id = session_id();
$cart_items = getCartItems($pdo, $session_id);
$subtotal   = getCartTotal($pdo, $session_id);
$tax        = round($subtotal * 0.10, 2);
$total      = $subtotal + $tax;
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cart - Tech Store</title>
   <link rel="icon" type="image/x-icon" href="assets/images/favicon2.png">
    <link rel="stylesheet" href="assets/css/style.css">
    <link href="https://fonts.googleapis.com/css2?family=DM+Sans:wght@300;400;500;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
</head>

<body>
    <?php include 'includes/navbar.php'; ?>

    <div style="max-width:1100px;margin:50px auto;padding:0 20px;">
        <h2 class="cart-title">Shopping Cart</h2>

        <?php if (count($cart_items) > 0): ?>
            <div class="cart-page">
                <!-- Cart Items -->
                <div class="cart-items">
                    <?php foreach ($cart_items as $item): ?>
                        <div class="cart-item" id="cart-item-<?= $item['id'] ?>">
                            <img src="<?= htmlspecialchars($item['image']) ?>"
                                alt="<?= htmlspecialchars($item['name']) ?>"
                                onerror="this.src='assets/images/placeholder.jpg'">
                            <div class="cart-item-info">
                                <div class="cart-item-name"><?= htmlspecialchars($item['name']) ?></div>
                                <div class="cart-item-cat"><?= htmlspecialchars($item['category']) ?></div>
                                <div class="cart-item-price">Rs. <?= number_format($item['price'], 2) ?></div>
                                <div class="qty-control">
                                    <button class="qty-btn" onclick="updateQty(<?= $item['id'] ?>, -1)">−</button>
                                    <span id="qty-<?= $item['id'] ?>"><?= $item['quantity'] ?></span>
                                    <button class="qty-btn" onclick="updateQty(<?= $item['id'] ?>, 1)">+</button>
                                </div>
                            </div>
                            <button class="remove-btn" onclick="removeItem(<?= $item['id'] ?>)">
                                <i class="fas fa-trash"></i>
                            </button>
                        </div>
                    <?php endforeach; ?>
                </div>

                <!-- Order Summary -->
                <div class="order-summary">
                    <h3>Order Summary</h3>
                    <div class="summary-row"><span>Subtotal</span><span>Rs. <?= number_format($subtotal, 2) ?></span></div>
                    <div class="summary-row"><span>Shipping</span><span>Free</span></div>
                    <div class="summary-row"><span>Tax (10%)</span><span>Rs. <?= number_format($tax, 2) ?></span></div>
                    <div class="summary-total">
                        <span>Total</span>
                        <span>Rs. <?= number_format($total, 2) ?></span>
                    </div>
                    <a href="checkout.php" class="btn btn-dark btn-full" style="margin-top:20px;">
                        Proceed to Checkout &rarr;
                    </a>
                    <a href="products.php" class="btn-guest" style="margin-top:10px;">
                        Continue Shopping
                    </a>
                </div>
            </div>

        <?php else: ?>
            <div style="text-align:center;padding:80px 20px;color:#888;">
                <i class="fas fa-shopping-cart" style="font-size:4rem;margin-bottom:20px;display:block;"></i>
                <h3 style="margin-bottom:10px;">Your cart is empty</h3>
                <p style="margin-bottom:24px;">Add some products to get started!</p>
                <a href="products.php" class="btn btn-dark">Shop Now</a>
            </div>
        <?php endif; ?>
    </div>

    <?php include 'includes/footer.php'; ?>
    <script src="assets/js/main.js"></script>
</body>

</html>