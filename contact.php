<?php
session_start();
require_once 'config/database.php';
require_once 'includes/functions.php';

$success = '';
$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name    = trim($_POST['name']);
    $email   = trim($_POST['email']);
    $subject = trim($_POST['subject']);
    $message = trim($_POST['message']);

    if ($name && $email && $subject && $message) {
        $stmt = $pdo->prepare("INSERT INTO contacts (name, email, subject, message) VALUES (?, ?, ?, ?)");
        $stmt->execute([$name, $email, $subject, $message]);
        $success = 'Message sent successfully! We will respond within 24 hours.';
    } else {
        $error = 'Please fill in all fields.';
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Contact - Tech Store</title>
    <link rel="stylesheet" href="assets/css/style.css">
    <link href="https://fonts.googleapis.com/css2?family=DM+Sans:wght@300;400;500;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
</head>
<body>
<?php include 'includes/navbar.php'; ?>

<div class="contact-page">

    <!-- Contact Cards -->
    <div class="contact-cards">
        <div class="contact-card">
            <div class="contact-card-icon">📧</div>
            <h3>Email Us</h3>
            <p>Asim&Ali@gmail.com</p>
            <p>We'll respond within 24 hours</p>
        </div>
        <div class="contact-card">
            <div class="contact-card-icon">📞</div>
            <h3>Call Us</h3>
            <p>SHOP</p>
            <p>Mon-Fri: 9am-6pm</p>
        </div>
        <div class="contact-card">
            <div class="contact-card-icon">📍</div>
            <h3>Visit Us</h3>
            <p>Abasyn University Islamabad Campus</p>
            <p>Islamabad, Pakistan</p>
        </div>
    </div>

    <!-- Contact Form -->
    <div class="contact-form">
        <h2>Send us a message</h2>

        <?php if($success): ?>
            <div style="background:#e0ffe0;color:#080;padding:12px;border-radius:8px;margin-bottom:20px;font-size:0.9rem;">
                <?= $success ?>
            </div>
        <?php endif; ?>
        <?php if($error): ?>
            <div style="background:#ffe0e0;color:#c00;padding:12px;border-radius:8px;margin-bottom:20px;font-size:0.9rem;">
                <?= $error ?>
            </div>
        <?php endif; ?>

        <form method="POST">
            <div class="form-row">
                <div class="form-group">
                    <label>Name</label>
                    <input type="text" name="name" placeholder="Your name" required>
                </div>
                <div class="form-group">
                    <label>Email</label>
                    <input type="email" name="email" placeholder="your@email.com" required>
                </div>
            </div>
            <div class="form-group">
                <label>Subject</label>
                <input type="text" name="subject" placeholder="How can we help?" required>
            </div>
            <div class="form-group">
                <label>Message</label>
                <textarea name="message" placeholder="Tell us how we can help you..." required></textarea>
            </div>
            <button type="submit" class="btn btn-dark">
                <i class="fas fa-paper-plane"></i> Send Message
            </button>
        </form>
    </div>
</div>

<?php include 'includes/footer.php'; ?>
</body>
</html>