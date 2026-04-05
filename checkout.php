<?php
session_start();
require_once 'config/database.php';
require_once 'includes/functions.php';

$session_id = session_id();
$cart_items = getCartItems($pdo, $session_id);
$subtotal   = getCartTotal($pdo, $session_id);
$tax        = round($subtotal * 0.10, 2);
$total      = $subtotal + $tax;

if(count($cart_items) === 0) {
    header('Location: cart.php');
    exit;
}

$error = '';

if($_SERVER['REQUEST_METHOD'] === 'POST') {
    $first_name      = trim($_POST['first_name']);
    $last_name       = trim($_POST['last_name']);
    $email           = trim($_POST['email']);
    $phone           = trim($_POST['phone']);
    $street          = trim($_POST['street']);
    $city            = trim($_POST['city']);
    $state           = trim($_POST['state']);
    $zip             = trim($_POST['zip']);
    $country         = trim($_POST['country']);
    $payment_method  = $_POST['payment_method'];
    $easypaisa_no    = isset($_POST['easypaisa_number']) ? trim($_POST['easypaisa_number']) : '';
    $full_name       = $first_name . ' ' . $last_name;

    // Insert Order
    $stmt = $pdo->prepare("INSERT INTO orders 
        (user_id, full_name, email, phone, street, city, state, zip, country, payment_method, easypaisa_number, subtotal, tax, total)
        VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
    $stmt->execute([
        $_SESSION['user_id'] ?? null,
        $full_name, $email, $phone,
        $street, $city, $state, $zip, $country,
        $payment_method, $easypaisa_no,
        $subtotal, $tax, $total
    ]);
    $order_id = $pdo->lastInsertId();

    // Insert Order Items
    foreach($cart_items as $item) {
        $stmt = $pdo->prepare("INSERT INTO order_items (order_id, product_id, quantity, price) VALUES (?, ?, ?, ?)");
        $stmt->execute([$order_id, $item['product_id'], $item['quantity'], $item['price']]);
    }

    // Clear Cart
    $stmt = $pdo->prepare("DELETE FROM cart WHERE session_id = ?");
    $stmt->execute([$session_id]);

    header("Location: order_confirm.php?id=$order_id");
    exit;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Checkout - TechStore</title>
    <link rel="stylesheet" href="assets/css/style.css">
    <link href="https://fonts.googleapis.com/css2?family=DM+Sans:wght@300;400;500;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
</head>
<body>
<?php include 'includes/navbar.php'; ?>

<div style="max-width:1100px;margin:50px auto;padding:0 20px;">
    <h2 style="font-size:2rem;font-weight:700;margin-bottom:30px;">Checkout</h2>

    <div style="display:grid;grid-template-columns:1fr 350px;gap:30px;">
        <!-- Left Form -->
        <div>
            <?php if(!isset($_SESSION['user_id'])): ?>
            <div style="background:#f0efff;border-radius:10px;padding:16px;margin-bottom:20px;font-size:0.9rem;">
                Checking out as guest — <a href="signin.php" style="color:#6c63ff;">Want to save your order history? Sign in</a>
            </div>
            <?php endif; ?>

            <form method="POST" id="checkoutForm">
                <!-- Contact Info -->
                <div style="background:#fff;border:1px solid #eee;border-radius:12px;padding:24px;margin-bottom:20px;">
                    <h3 style="margin-bottom:20px;">Contact Information</h3>
                    <div class="form-row">
                        <div class="form-group">
                            <label>First Name</label>
                            <input type="text" name="first_name" required>
                        </div>
                        <div class="form-group">
                            <label>Last Name</label>
                            <input type="text" name="last_name" required>
                        </div>
                    </div>
                    <div class="form-group">
                        <label>Email</label>
                        <input type="email" name="email" required>
                    </div>
                    <div class="form-group">
                        <label>Phone Number</label>
                        <input type="text" name="phone" placeholder="+92 300 1234567">
                    </div>
                </div>

                <!-- Shipping Address -->
                <div style="background:#fff;border:1px solid #eee;border-radius:12px;padding:24px;margin-bottom:20px;">
                    <h3 style="margin-bottom:20px;">Shipping Address</h3>
                    <div class="form-group">
                        <label>Street Address</label>
                        <input type="text" name="street" required>
                    </div>
                    <div class="form-row">
                        <div class="form-group">
                            <label>City</label>
                            <input type="text" name="city" required>
                        </div>
                        <div class="form-group">
                            <label>State/Province</label>
                            <input type="text" name="state">
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="form-group">
                            <label>ZIP/Postal Code</label>
                            <input type="text" name="zip">
                        </div>
                        <div class="form-group">
                            <label>Country</label>
                            <input type="text" name="country" value="Pakistan">
                        </div>
                    </div>
                </div>

                <!-- Payment Method -->
                <div style="background:#fff;border:1px solid #eee;border-radius:12px;padding:24px;margin-bottom:20px;">
                    <h3 style="margin-bottom:20px;">Payment Method</h3>

                    <div class="payment-option" id="pay-cod" onclick="selectPayment('cod')">
                        <input type="radio" name="payment_method" value="cod" id="cod" checked style="margin-right:8px;">
                        <label for="cod">💵 Cash on Delivery</label>
                        <p>Pay with cash when your order is delivered</p>
                    </div>

                    <div class="payment-option" id="pay-easypaisa" onclick="selectPayment('easypaisa')">
                        <input type="radio" name="payment_method" value="easypaisa" id="easypaisa" style="margin-right:8px;">
                        <label for="easypaisa">📱 Easypaisa</label>
                        <p>Pay securely with your Easypaisa account</p>
                        <div id="easypaisa-field" style="display:none;margin-top:10px;">
                            <label style="font-size:0.85rem;font-weight:600;">Easypaisa Account Number</label>
                            <input type="text" name="easypaisa_number" placeholder="03XX XXXXXXX"
                                   style="width:100%;padding:10px;border:1px solid #ddd;border-radius:8px;margin-top:6px;">
                        </div>
                    </div>

                    <div class="payment-option" id="pay-jazzcash" onclick="selectPayment('jazzcash')">
                        <input type="radio" name="payment_method" value="jazzcash" id="jazzcash" style="margin-right:8px;">
                        <label for="jazzcash">💳 JazzCash</label>
                        <p>Pay securely with your JazzCash account</p>
                    </div>

                    <p style="font-size:0.8rem;color:#888;margin-top:14px;">
                        🔒 Your payment information is secure and encrypted
                    </p>
                </div>

                <button type="submit" class="btn btn-dark btn-full">Place Order</button>
            </form>
        </div>

        <!-- Order Summary -->
        <div class="order-summary" style="height:fit-content;position:sticky;top:80px;">
            <h3>Order Summary</h3>
            <?php foreach($cart_items as $item): ?>
            <div style="display:flex;gap:12px;align-items:center;margin-bottom:14px;">
                <img src="<?= htmlspecialchars($item['image']) ?>"
                     style="width:50px;height:50px;object-fit:cover;border-radius:6px;"
                     onerror="this.src='assets/images/placeholder.jpg'">
                <div>
                    <div style="font-size:0.9rem;font-weight:600;"><?= htmlspecialchars($item['name']) ?></div>
                    <div style="font-size:0.8rem;color:#888;">Qty: <?= $item['quantity'] ?></div>
                    <div style="font-size:0.85rem;color:#6c63ff;">Rs. <?= number_format($item['price'], 2) ?></div>
                </div>
            </div>
            <?php endforeach; ?>
            <hr style="margin:16px 0;border:none;border-top:1px solid #eee;">
            <div class="summary-row"><span>Subtotal</span><span>Rs. <?= number_format($subtotal, 2) ?></span></div>
            <div class="summary-row"><span>Shipping</span><span>Free</span></div>
            <div class="summary-row"><span>Tax (10%)</span><span>Rs. <?= number_format($tax, 2) ?></span></div>
            <div class="summary-total"><span>Total</span><span>Rs. <?= number_format($total, 2) ?></span></div>
        </div>
    </div>
</div>

<?php include 'includes/footer.php'; ?>
<script src="assets/js/main.js"></script>
<script>
function selectPayment(method) {
    document.querySelectorAll('.payment-option').forEach(el => el.classList.remove('selected'));
    document.getElementById('pay-' + method).classList.add('selected');
    document.getElementById(method).checked = true;
    document.getElementById('easypaisa-field').style.display = method === 'easypaisa' ? 'block' : 'none';
}
selectPayment('cod');
</script>
</body>
</html>