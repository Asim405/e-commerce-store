<?php
require_once 'config/database.php';

$new_columns = [
    'battery_life' => 'VARCHAR(100)',
    'warranty_years' => 'INT DEFAULT 1',
    'storage' => 'VARCHAR(100)',
    'ram' => 'VARCHAR(100)',
    'processor' => 'VARCHAR(200)',
    'weight' => 'VARCHAR(100)',
    'os' => 'VARCHAR(100)'
];

foreach ($new_columns as $column => $type) {
    try {
        $sql = "ALTER TABLE products ADD COLUMN $column $type";
        $pdo->exec($sql);
        echo "✓ Added $column column\n";
    } catch (Exception $e) {
        if (strpos($e->getMessage(), 'Duplicate') === false) {
            echo "⚠ $column: " . $e->getMessage() . "\n";
        }
    }
}

echo "\n✓ Database migration completed!\n";
?>
