<?php
session_start();
require_once 'config/database.php';
require_once 'includes/functions.php';

$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = trim($_POST['email']);
    $password = $_POST['password'];

    $stmt = $pdo->prepare("SELECT * FROM users WHERE email = ?");
    $stmt->execute([$email]);
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($user && password_verify($password, $user['password'])) {
        $_SESSION['user_id'] = $user['id'];
        $_SESSION['user_name'] = $user['full_name'];
        header('Location: index.php');
        exit;
    } else {
        $error = 'Invalid email or password!';
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sign In - TechStore</title>
    <link rel="stylesheet" href="assets/css/style.css">
    <link href="https://fonts.googleapis.com/css2?family=DM+Sans:wght@300;400;500;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
</head>
<body>
<?php include 'includes/navbar.php'; ?>

<div class="auth-page">
    <div class="auth-card">
        <div style="margin-bottom:16px;">🟣 <strong>Store</strong></div>
        <h2>Sign in</h2>
        <p>Enter your credentials to access your account</p>

        <?php if($error): ?>
            <div style="background:#ffe0e0;color:#c00;padding:10px;border-radius:8px;margin-bottom:16px;font-size:0.9rem;">
                <?= $error ?>
            </div>
        <?php endif; ?>

        <form method="POST">
            <div class="form-group">
                <label>Email Address</label>
                <input type="email" name="email" placeholder="you@example.com" required>
            </div>
            <div class="form-group">
                <label>Password</label>
                <input type="password" name="password" placeholder="••••••••" required>
            </div>
            <button type="submit" class="btn btn-dark btn-full">
                <i class="fas fa-sign-in-alt"></i> Sign In
            </button>
        </form>

        <div class="divider">OR</div>
        <a href="index.php" class="btn-guest">Continue as Guest</a>

        <div class="auth-footer">
            Don't have an account? <a href="signup.php">Sign up</a>
        </div>
        <div class="back-home">
            <a href="index.php">&larr; Back to Home</a>
        </div>
    </div>
</div>

<?php include 'includes/footer.php'; ?>
</body>
</html>