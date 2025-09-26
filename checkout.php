<?php
require_once './phplogin.php';
session_start();
$user = $_SESSION['user'] ?? null;
$panier = $_SESSION['panier'] ?? [];

if (!$user) {
    header('Location: ./accont_system/login.php');
    exit;
}
if (count($panier) === 0) {
    header('Location: ./shop/panier.php');
    exit;
}

$total = 0.0;
foreach ($panier as $i) {
    $total += $i['prix'] * $i['qte'];
}

$pdo->beginTransaction();
try {
    $stmt = $pdo->prepare('INSERT INTO orders (user_id, total) VALUES (?, ?)');
    $stmt->execute([$user['id'], $total]);
    $order_id = $pdo->lastInsertId();
    $insert_item = $pdo->prepare('INSERT INTO order_items (order_id, product_id, quantity, price) VALUES (?, ?, ?, ?)');
    foreach ($panier as $it) {
        $insert_item->execute([$order_id, (int)$it['id'], (int)$it['qte'], $it['prix']]);
    }
    $pdo->commit();
    // Clear cart
    unset($_SESSION['panier']);
    header('Location: panier.php?checkout=success');
    exit;
} catch (Exception $e) {
    $pdo->rollBack();
    echo "Erreur lors de la création de la commande: " . htmlspecialchars($e->getMessage());
}
?>