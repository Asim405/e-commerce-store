<?php
$host = '127.0.0.1';
$port = '3307';
$dbname = 'techstore';
$username = 'root';
$password = '';

try {
    $pdo = new PDO("mysql:host=$host;port=$port;dbname=$dbname;charset=utf8", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
    // Initialize gadget specification columns if they don't exist
    initializeGadgetSpecs();
} catch (PDOException $e) {
    die("Connection failed: " . $e->getMessage());
}

function initializeGadgetSpecs() {
    global $pdo;
    
    $columns = [
        'battery_life' => 'VARCHAR(100)',
        'warranty_years' => 'INT DEFAULT 1',
        'storage' => 'VARCHAR(100)',
        'ram' => 'VARCHAR(100)',
        'processor' => 'VARCHAR(200)',
        'weight' => 'VARCHAR(100)',
        'os' => 'VARCHAR(100)'
    ];
    
    foreach ($columns as $column => $type) {
        try {
            // Check if column exists
            $stmt = $pdo->prepare("SELECT * FROM products LIMIT 1");
            $stmt->execute();
            
            // Try to add the column
            $pdo->exec("ALTER TABLE products ADD COLUMN $column $type");
        } catch (Exception $e) {
            // Column might already exist, which is fine
        }
    }
}
?>