<?php
session_start();
require_once '../config/database.php';
require_once '../includes/functions.php';

header('Content-Type: application/json');

$action     = $_POST['action'] ?? '';
$session_id = session_id();

if ($action === 'add') {
    $product_id = (int)$_POST['product_id'];
    $quantity   = isset($_POST['quantity']) ? (int)$_POST['quantity'] : 1;
    $quantity   = max(1, $quantity); // Ensure quantity is at least 1

    // Check if already in cart
    $stmt = $pdo->prepare("SELECT id, quantity FROM cart WHERE session_id = ? AND product_id = ?");
    $stmt->execute([$session_id, $product_id]);
    $existing = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($existing) {
        $stmt = $pdo->prepare("UPDATE cart SET quantity = quantity + ? WHERE id = ?");
        $stmt->execute([$quantity, $existing['id']]);
    } else {
        $stmt = $pdo->prepare("INSERT INTO cart (session_id, product_id, quantity) VALUES (?, ?, ?)");
        $stmt->execute([$session_id, $product_id, $quantity]);
    }

    echo json_encode([
        'success'    => true,
        'cart_count' => getCartCount($pdo, $session_id)
    ]);
}

elseif ($action === 'update') {
    $cart_id = (int)$_POST['cart_id'];
    $change  = (int)$_POST['change'];

    $stmt = $pdo->prepare("SELECT quantity FROM cart WHERE id = ?");
    $stmt->execute([$cart_id]);
    $item = $stmt->fetch(PDO::FETCH_ASSOC);

    $new_qty = $item['quantity'] + $change;

    if ($new_qty <= 0) {
        $stmt = $pdo->prepare("DELETE FROM cart WHERE id = ?");
        $stmt->execute([$cart_id]);
    } else {
        $stmt = $pdo->prepare("UPDATE cart SET quantity = ? WHERE id = ?");
        $stmt->execute([$new_qty, $cart_id]);
    }

    echo json_encode([
        'success'    => true,
        'quantity'   => $new_qty,
        'cart_count' => getCartCount($pdo, $session_id)
    ]);
}

elseif ($action === 'remove') {
    $cart_id = (int)$_POST['cart_id'];
    $stmt = $pdo->prepare("DELETE FROM cart WHERE id = ?");
    $stmt->execute([$cart_id]);

    echo json_encode([
        'success'    => true,
        'cart_count' => getCartCount($pdo, $session_id)
    ]);
}

else {
    echo json_encode(['success' => false, 'message' => 'Invalid action']);
}
?>