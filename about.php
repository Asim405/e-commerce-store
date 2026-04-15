<?php
session_start();
require_once 'config/database.php';
require_once 'includes/functions.php';
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>About - Gadget Hub</title>
   <link rel="stylesheet" href="assets/css/style.css">
    <link rel="stylesheet" href="assets/css/chatbot.css">
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@700&family=DM+Sans:wght@300;400;500;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
</head>

<body>
    <?php include 'includes/navbar.php'; ?>

    <div style="max-width:900px;margin:60px auto;padding:0 20px;text-align:center;">
        <h1 style="font-family:'Playfair Display',serif;font-size:2.5rem;color:#fcab4f;margin-bottom:16px;">
            About Gadget Hub
        </h1>
        <p style="color:#888;font-size:1.05rem;line-height:1.8;margin-bottom:50px;">
            We are a premium tech store offering the latest gadgets and electronics
            at unbeatable prices. Our mission is to bring you the best technology
            with fast shipping and exceptional customer service.
        </p>

        <div style="display:grid;grid-template-columns:repeat(3,1fr);gap:24px;margin-bottom:50px;">
            <div style="border:1px solid #eee;border-radius:12px;padding:30px;">
                <div style="font-size:2.5rem;margin-bottom:12px;">🚀</div>
                <h3 style="margin-bottom:8px;">Fast Shipping</h3>
                <p style="color:#888;font-size:0.9rem;">Delivery across Pakistan within 2-5 business days</p>
            </div>
            <div style="border:1px solid #eee;border-radius:12px;padding:30px;">
                <div style="font-size:2.5rem;margin-bottom:12px;">⭐</div>
                <h3 style="margin-bottom:8px;">Premium Quality</h3>
                <p style="color:#888;font-size:0.9rem;">Only genuine and certified tech products</p>
            </div>
            <div style="border:1px solid #eee;border-radius:12px;padding:30px;">
                <div style="font-size:2.5rem;margin-bottom:12px;">💬</div>
                <h3 style="margin-bottom:8px;">24/7 Support</h3>
                <p style="color:#888;font-size:0.9rem;">Always here to help you with any questions</p>
            </div>
        </div>

        <div style="background:#f5f5f5;border-radius:16px;padding:40px;">
            <h2 style="margin-bottom:16px;">Meet the Team</h2>
            <div style="display:flex;justify-content:center;gap:40px;">
                <div>
                    <div style="width:80px;height:80px;background:#fcab4f;border-radius:50%;margin:0 auto 12px;display:flex;align-items:center;justify-content:center;color:#fff;font-size:1.5rem;">A</div>
                    <h4>Asim Sultan</h4>
                    <p style="color:#888;font-size:0.85rem;">Student ID: 9008</p>
                </div>
                <div>
                    <div style="width:80px;height:80px;background:#fcab4f;border-radius:50%;margin:0 auto 12px;display:flex;align-items:center;justify-content:center;color:#fff;font-size:1.5rem;">A</div>
                    <h4>Ali Imtiaz</h4>
                    <p style="color:#888;font-size:0.85rem;">Student ID: 9064</p>
                </div>
            </div>
        </div>
    </div>

    <?php include 'includes/footer.php'; ?>

    <!-- Chatbot Toggle Button -->
    <button id="chatbot-toggle" class="chatbot-toggle-btn" title="Chat with us">
        <i class="fas fa-comment-dots"></i>
    </button>

    <!-- Chatbot Container -->
    <div id="chatbot-container" class="chatbot-container" style="display: none;">
        <div class="chatbot-header">
            <h3>TechStore Assistant</h3>
            <button id="chatbot-close" class="chatbot-close-btn">×</button>
        </div>
        <div id="chatbot-messages" class="chatbot-messages"></div>
        <div class="chatbot-input-area">
            <input type="text" id="chatbot-input" class="chatbot-input" placeholder="Type your message...">
            <button id="chatbot-send" class="chatbot-send-btn"><i class="fas fa-paper-plane"></i></button>
        </div>
    </div>

    <script src="assets/js/chatbot.js"></script></body>

</html>