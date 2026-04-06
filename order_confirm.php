<?php
session_start();
require_once 'config/database.php';
require_once 'includes/functions.php';

$order_id = isset($_GET['id']) ? (int)$_GET['id'] : 0;
$stmt = $pdo->prepare("SELECT * FROM orders WHERE id = ?");
$stmt->execute([$order_id]);
$order = $stmt->fetch(PDO::FETCH_ASSOC);

if(!$order) {
    header('Location: index.php');
    exit;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Order Confirmed - TechStore</title>
    <link rel="stylesheet" href="assets/css/style.css">
    <link href="https://fonts.googleapis.com/css2?family=DM+Sans:wght@300;400;500;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
</head>
<body>
<?php include 'includes/navbar.php'; ?>

<div style="max-width:600px;margin:80px auto;padding:0 20px;text-align:center;">
    <div style="background:#fff;border:1px solid #eee;border-radius:16px;padding:50px 40px;">
        <div style="font-size:4rem;margin-bottom:20px;">✅</div>
        <h2 style="font-size:1.8rem;font-weight:700;margin-bottom:10px;">Order Confirmed!</h2>
        <p style="color:#888;margin-bottom:24px;">
            Thank you <strong><?= htmlspecialchars($order['full_name']) ?></strong>!<br>
            Your order has been placed successfully.
        </p>
        <div style="background:#f5f5f5;border-radius:10px;padding:20px;margin-bottom:24px;text-align:left;">
            <div style="display:flex;justify-content:space-between;margin-bottom:10px;">
                <span style="color:#888;">Order ID</span>
                <strong>#<?= str_pad($order['id'], 6, '0', STR_PAD_LEFT) ?></strong>
            </div>
            <div style="display:flex;justify-content:space-between;margin-bottom:10px;">
                <span style="color:#888;">Payment</span>
                <strong><?= ucfirst($order['payment_method']) ?></strong>
            </div>
            <div style="display:flex;justify-content:space-between;margin-bottom:10px;">
                <span style="color:#888;">Total</span>
                <strong style="color:#6c63ff;">Rs. <?= number_format($order['total'], 2) ?></strong>
            </div>
            <div style="display:flex;justify-content:space-between;">
                <span style="color:#888;">Status</span>
                <strong style="color:green;">Pending</strong>
            </div>
        </div>
        <a href="index.php" class="btn btn-dark">Back to Home</a>
        <a href="products.php" class="btn btn-outline" style="margin-left:10px;">Continue Shopping</a>
    </div>
</div>

<?php include 'includes/footer.php'; ?>
</body>
</html>