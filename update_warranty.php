<?php
require_once 'config/database.php';

// Update warranty years for each product
$warranty_updates = [
    1 => 2,  // Premium Wireless Headphones - 2 years
    2 => 1,  // True Wireless Earbuds - 1 year
    3 => 2,  // Smart Watch Pro - 2 years
    4 => 2,  // UltraBook Laptop - 2 years
    5 => 1,  // Flagship Smartphone - 1 year
    6 => 1,  // Professional Camera - 1 year
    7 => 1,  // Premium Tablet - 1 year
    8 => 1   // RGB Gaming Keyboard - 1 year
];

echo "<h2>Updating Warranty Information</h2>";

foreach ($warranty_updates as $product_id => $years) {
    try {
        $stmt = $pdo->prepare("UPDATE products SET warranty_years = ? WHERE id = ?");
        $stmt->execute([$years, $product_id]);
        echo "✓ Product ID $product_id: Updated to $years year(s) warranty<br>";
    } catch (Exception $e) {
        echo "✗ Error updating product ID $product_id: " . $e->getMessage() . "<br>";
    }
}

echo "<br><strong>✓ All warranty information updated successfully!</strong><br>";
echo "<a href='products.php'>← View Products</a>";
?>
