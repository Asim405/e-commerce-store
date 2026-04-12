<?php
$cart_count = isset($pdo) ? getCartCount($pdo, session_id()) : 0;
?>
<nav class="navbar">
    <div class="nav-container">
        <a href="index.php" class="nav-logo">
            <img src="assets/images/favicon2.png" alt="Store Logo" class="logo-img">
        </a>
        <ul class="nav-links">
            <li><a href="index.php">Home</a></li>
            <li><a href="products.php">Products</a></li>
            <li><a href="about.php">About</a></li>
            <li><a href="contact.php">Contact</a></li>
        </ul>
        <div class="nav-icons">
            <a href="#" class="icon-btn" id="searchBtn"><i class="fas fa-search"></i></a>
            <?php if(isset($_SESSION['user_id'])): ?>
                <a href="logout.php" class="icon-btn"><i class="fas fa-user"></i></a>
            <?php else: ?>
                <a href="signin.php" class="icon-btn"><i class="fas fa-user"></i></a>
            <?php endif; ?>
            <a href="cart.php" class="icon-btn cart-icon">
                <i class="fas fa-shopping-cart"></i>
                <?php if($cart_count > 0): ?>
                    <span class="cart-badge"><?= $cart_count ?></span>
                <?php endif; ?>
            </a>
        </div>
    </div>
</nav>