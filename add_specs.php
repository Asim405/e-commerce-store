<?php
require_once 'config/database.php';

// Sample gadget specifications for existing products
$specs = [
    1 => [ // Premium Wireless Headphones
        'battery_life' => '40 hrs',
        'warranty_years' => 2,
        'weight' => '250g',
        'os' => 'Compatible with iOS & Android'
    ],
    2 => [ // True Wireless Earbuds
        'battery_life' => '7 hrs (single), 35 hrs total',
        'warranty_years' => 1,
        'weight' => '6.5g each',
        'os' => 'Compatible with iOS & Android'
    ],
    3 => [ // Smart Watch Pro
        'battery_life' => '5 days',
        'warranty_years' => 2,
        'storage' => '8GB',
        'weight' => '45g',
        'os' => 'watchOS & Wear OS'
    ],
    4 => [ // UltraBook Laptop
        'battery_life' => '14 hrs',
        'warranty_years' => 2,
        'storage' => '512GB SSD',
        'ram' => '16GB',
        'processor' => 'Intel Core i7 (13th Gen)',
        'weight' => '1.2kg',
        'os' => 'Windows 11'
    ],
    5 => [ // Flagship Smartphone
        'battery_life' => '24 hrs',
        'warranty_years' => 1,
        'storage' => '256GB',
        'ram' => '12GB',
        'processor' => 'Qualcomm Snapdragon 8 Gen 2',
        'weight' => '170g',
        'os' => 'Android 14'
    ],
    6 => [ // Professional Camera
        'battery_life' => '400 shots',
        'warranty_years' => 1,
        'storage' => 'SD Card (up to 1TB)',
        'weight' => '650g',
        'processor' => 'Dual DIGIC X'
    ],
    7 => [ // Premium Tablet
        'battery_life' => '10 hrs',
        'warranty_years' => 1,
        'storage' => '256GB',
        'ram' => '8GB',
        'weight' => '480g',
        'os' => 'iPadOS 17'
    ],
    8 => [ // RGB Gaming Keyboard
        'battery_life' => '30 hrs (wireless)',
        'warranty_years' => 1,
        'weight' => '750g',
        'os' => 'Windows & Mac'
    ]
];

foreach ($specs as $product_id => $spec_data) {
    try {
        $set_clauses = [];
        $params = [];
        
        foreach ($spec_data as $key => $value) {
            $set_clauses[] = "$key = ?";
            $params[] = $value;
        }
        
        $params[] = $product_id;
        
        $sql = "UPDATE products SET " . implode(', ', $set_clauses) . " WHERE id = ?";
        $stmt = $pdo->prepare($sql);
        $stmt->execute($params);
        
        echo "✓ Updated specs for product ID: $product_id<br>";
    } catch (Exception $e) {
        echo "✗ Error updating product ID $product_id: " . $e->getMessage() . "<br>";
    }
}

echo "<br><strong>✓ All gadget specifications have been added successfully!</strong><br>";
echo "<a href='products.php'>← Back to Products</a>";
?>
