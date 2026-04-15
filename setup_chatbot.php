<?php
require_once 'config/database.php';

try {
    // Create chatbot conversations table
    $pdo->exec("CREATE TABLE IF NOT EXISTS chatbot_conversations (
        id INT PRIMARY KEY AUTO_INCREMENT,
        visitor_id VARCHAR(100) NOT NULL,
        message TEXT NOT NULL,
        response TEXT NOT NULL,
        category VARCHAR(50) DEFAULT 'general',
        created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
    )");
    echo "✓ Chatbot conversations table created<br>";
    
    // Create chatbot knowledge base table
    $pdo->exec("CREATE TABLE IF NOT EXISTS chatbot_kb (
        id INT PRIMARY KEY AUTO_INCREMENT,
        keyword VARCHAR(255) NOT NULL,
        response TEXT NOT NULL,
        category VARCHAR(50) NOT NULL,
        priority INT DEFAULT 1,
        active TINYINT DEFAULT 1
    )");
    echo "✓ Chatbot knowledge base table created<br>";
    
    // Insert predefined responses
    $responses = [
        // Product queries
        ['smart watch', 'The Smart Watch Pro is an advanced wearable with fitness tracking, heart rate monitoring, and smartphone connectivity. Price: Rs. 399.99. Battery life: 5 days. Warranty: 2 years. Would you like more details?', 'products', 1],
        ['headphones', 'We have Premium Wireless Headphones with active noise cancellation. Price: Rs. 299.99. Battery: 40 hours. Warranty: 2 years. Interested?', 'products', 1],
        ['earbuds', 'True Wireless Earbuds are perfect for on-the-go. Price: Rs. 149.99. Battery: 7 hours (single charge). Warranty: 1 year. Want more info?', 'products', 1],
        ['laptop', 'Our UltraBook Laptop is powerful and portable. Price: Rs. 1299.99. Specs: Core i7, 16GB RAM, 512GB SSD, 14-hour battery. Warranty: 2 years.', 'products', 1],
        ['smartphone', 'Flagship Smartphone with latest features. Price: Rs. 899.99. Storage: 256GB, RAM: 12GB, Processor: Snapdragon 8 Gen 2. Warranty: 1 year.', 'products', 1],
        ['camera', 'Professional Camera for stunning photos. Price: Rs. 1899.99. Great for photography enthusiasts. Warranty: 1 year.', 'products', 1],
        ['tablet', 'Premium Tablet with large display. Price: Rs. 649.99. Perfect for productivity and entertainment. Warranty: 1 year.', 'products', 1],
        ['keyboard', 'RGB Gaming Keyboard with mechanical switches. Price: Rs. 179.99. Customizable lighting. Warranty: 1 year.', 'products', 1],
        ['price', 'We offer products ranging from Rs. 149.99 to Rs. 1899.99. What product interests you?', 'products', 1],
        
        // Order & Tracking
        ['track order', 'To track your order, please provide your Order ID. You can find it in your confirmation email. What is your Order ID?', 'orders', 2],
        ['order status', 'You can check your order status by providing your Order ID or Email. We\'ll fetch the latest details for you.', 'orders', 2],
        ['where is my order', 'I can help track your order! Please share your Order ID from your confirmation email.', 'orders', 2],
        ['delivery', 'Standard delivery takes 3-5 business days. Express delivery takes 1-2 business days. Which would you prefer?', 'orders', 2],
        ['shipping', 'We ship nationwide. Shipping cost is calculated at checkout based on your location.', 'orders', 2],
        
        // Warranty & Returns
        ['warranty', 'Our products come with manufacturer warranty ranging from 1-2 years. What product are you asking about?', 'support', 3],
        ['return', 'You can return products within 30 days of purchase if unused and in original packaging. Would you like a return authorization?', 'support', 3],
        ['guarantee', 'All our products are guaranteed authentic and covered by warranty. Customer satisfaction is our priority.', 'support', 3],
        ['refund', 'Refunds are processed within 5-7 business days after we receive and verify the returned item.', 'support', 3],
        
        // Payment
        ['payment', 'We accept multiple payment methods including Credit/Debit Cards, Easypaisa, and Bank Transfer. Which do you prefer?', 'billing', 3],
        ['easypaisa', 'Yes, we accept Easypaisa! It\'s a quick and secure payment method. Provide your Easypaisa number during checkout.', 'billing', 3],
        ['credit card', 'Yes, we accept all major credit and debit cards. Your payment is secure and encrypted.', 'billing', 3],
        
        // General
        ['hello', 'Hello! Welcome to TechStore 👋 How can I help you today? You can ask about products, orders, shipping, or anything else!', 'general', 2],
        ['hi', 'Hi there! 😊 What can I assist you with? Products, orders, or support?', 'general', 2],
        ['help', 'I\'m here to help! You can ask me about:\n- Products and pricing\n- Order tracking\n- Warranty & returns\n- Payment methods\n- General inquiries\n\nWhat would you like to know?', 'general', 2],
        ['contact', 'You can contact us via:\n- Email: support@techstore.com\n- Phone: +92-300-XXXX-XXXX\n- Contact form on our Contact page\nHow else can I help?', 'general', 1],
        ['hours', 'We\'re available Monday-Saturday, 10 AM - 6 PM. Sunday: 12 PM - 4 PM. How can I assist?', 'general', 1],
        ['thank you', 'You\'re welcome! 😊 Is there anything else I can help you with?', 'general', 2],
        ['thanks', 'Happy to help! Let me know if you need anything else! 👍', 'general', 2],
    ];
    
    foreach ($responses as $r) {
        try {
            $stmt = $pdo->prepare("INSERT IGNORE INTO chatbot_kb (keyword, response, category, priority) VALUES (?, ?, ?, ?)");
            $stmt->execute($r);
        } catch (Exception $e) {
            // Duplicate entries are okay
        }
    }
    
    echo "✓ Knowledge base populated with " . count($responses) . " responses<br>";
    echo "<br><strong>✓ Chatbot database setup complete!</strong><br>";
    echo "<a href='about.php'>← Back to About Page</a>";
    
} catch (Exception $e) {
    echo "✗ Error: " . $e->getMessage();
}
?>
