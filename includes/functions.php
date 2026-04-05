<?php
function getFeaturedProducts($pdo, $limit = 4) {
    $stmt = $pdo->prepare("SELECT * FROM products WHERE featured = 1 LIMIT ?");
    $stmt->execute([$limit]);
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

function getAllProducts($pdo, $category = '') {
    if ($category && $category !== 'All') {
        $stmt = $pdo->prepare("SELECT * FROM products WHERE category = ?");
        $stmt->execute([$category]);
    } else {
        $stmt = $pdo->query("SELECT * FROM products");
    }
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

function getCartItems($pdo, $session_id) {
    $stmt = $pdo->prepare("
        SELECT c.*, p.name, p.price, p.image, p.category 
        FROM cart c 
        JOIN products p ON c.product_id = p.id 
        WHERE c.session_id = ?
    ");
    $stmt->execute([$session_id]);
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

function getCartCount($pdo, $session_id) {
    $stmt = $pdo->prepare("SELECT SUM(quantity) FROM cart WHERE session_id = ?");
    $stmt->execute([$session_id]);
    return $stmt->fetchColumn() ?? 0;
}

function getCartTotal($pdo, $session_id) {
    $stmt = $pdo->prepare("
        SELECT SUM(p.price * c.quantity) 
        FROM cart c 
        JOIN products p ON c.product_id = p.id 
        WHERE c.session_id = ?
    ");
    $stmt->execute([$session_id]);
    return $stmt->fetchColumn() ?? 0;
}
?>