<?php
session_start();
require_once 'config/database.php';
require_once 'includes/functions.php';

$error = '';
$success = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $full_name = trim($_POST['full_name']);
    $email     = trim($_POST['email']);
    $phone     = trim($_POST['phone']);
    $password  = $_POST['password'];
    $confirm   = $_POST['confirm_password'];

    if ($password !== $confirm) {
        $error = 'Passwords do not match!';
    } else {
        // Check if email exists
        $stmt = $pdo->prepare("SELECT id FROM users WHERE email = ?");
        $stmt->execute([$email]);

        if ($stmt->fetch()) {
            $error = 'Email already registered!';
        } else {
            $hashed = password_hash($password, PASSWORD_DEFAULT);
            $stmt = $pdo->prepare("INSERT INTO users (full_name, email, phone, password) VALUES (?, ?, ?, ?)");
            $stmt->execute([$full_name, $email, $phone, $hashed]);
            $success = 'Account created! You can now sign in.';
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sign Up - TechStore</title>
    <link rel="stylesheet" href="assets/css/style.css">
    <link href="https://fonts.googleapis.com/css2?family=DM+Sans:wght@300;400;500;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
</head>
<body>
<?php include 'includes/navbar.php'; ?>

<div class="auth-page">
    <div class="auth-card">
        <div style="margin-bottom:16px;">🟣 <strong>TechStore</strong></div>
        <h2>Create your account</h2>
        <p>Sign up to start shopping with us</p>

        <?php if($error): ?>
            <div style="background:#ffe0e0;color:#c00;padding:10px;border-radius:8px;margin-bottom:16px;font-size:0.9rem;">
                <?= $error ?>
            </div>
        <?php endif; ?>
        <?php if($success): ?>
            <div style="background:#e0ffe0;color:#080;padding:10px;border-radius:8px;margin-bottom:16px;font-size:0.9rem;">
                <?= $success ?> <a href="signin.php">Sign in</a>
            </div>
        <?php endif; ?>

        <form method="POST">
            <div class="form-group">
                <label>Full Name</label>
                <input type="text" name="full_name" placeholder="John Doe" required>
            </div>
            <div class="form-group">
                <label>Email Address</label>
                <input type="email" name="email" placeholder="you@example.com" required>
            </div>
            <div class="form-group">
                <label>Phone Number (Optional)</label>
                <input type="text" name="phone" placeholder="+92 300 1234567">
            </div>
            <div class="form-group">
                <label>Password</label>
                <input type="password" name="password" placeholder="••••••••" required>
            </div>
            <div class="form-group">
                <label>Confirm Password</label>
                <input type="password" name="confirm_password" placeholder="••••••••" required>
            </div>
            <button type="submit" class="btn btn-dark btn-full">
                <i class="fas fa-user-plus"></i> Create Account
            </button>
        </form>

        <div class="auth-footer">
            Already have an account? <a href="signin.php">Sign in</a>
        </div>
        <div class="back-home">
            <a href="index.php">&larr; Back to Home</a>
        </div>
    </div>
</div>

<?php include 'includes/footer.php'; ?>
</body>
</html>