<?php
require_once './../phplogin.php'; // Connexion à la BDD
session_start();

$user = $_SESSION['user'] ?? null;
$panier = $_SESSION['panier'] ?? [];

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(403);
    die("Accès non autorisé.");
}

if (!$user) {
    die("Vous devez être connecté pour passer commande.");
}

if (empty($panier)) {
    die("Votre panier est vide.");
}

$user_id = $user['id'];
$total = 0.0;
foreach ($panier as $item) {
    $total += $item['prix'] * $item['qte'];
}

try {
    $pdo->beginTransaction();

    $stmt = $pdo->prepare("INSERT INTO orders (user_id, total) VALUES (?, ?)");
    $stmt->execute([$user_id, $total]);
    $order_id = $pdo->lastInsertId();


    $stmtItem = $pdo->prepare("INSERT INTO order_items (order_id, product_id, quantity, price) VALUES (?, ?, ?, ?)");
    foreach ($panier as $product_id => $item) {
        $stmtItem->execute([
            $order_id,
            $product_id,
            $item['qte'],
            $item['prix']
        ]);
    }

    $pdo->commit();

    unset($_SESSION['panier']);

    echo "Commande validée avec succès ! <a href='./../index.php'>Retour à la boutique</a>";

} catch (Exception $e) {
    $pdo->rollBack();
    die("Erreur lors de la validation de la commande : " . $e->getMessage());
}
