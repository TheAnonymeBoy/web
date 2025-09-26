<?php
require_once './../phplogin.php';
session_start();

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: index.php');
    exit;
}

$id = (int)($_POST['id'] ?? 0);
$qte = max(1, (int)($_POST['qte'] ?? 1));


$stmt = $pdo->prepare('SELECT id, nom, prix FROM produits WHERE id = ? LIMIT 1');
$stmt->execute([$id]);
$p = $stmt->fetch();

if (!$p) {
    $_SESSION['message'] = 'Produit introuvable.';
    header('Location: index.php');
    exit;
}

if (!isset($_SESSION['panier'])) {
    $_SESSION['panier'] = [];
}


if (isset($_SESSION['panier'][$id])) {
    $_SESSION['panier'][$id]['qte'] += $qte;
} else {
    $_SESSION['panier'][$id] = [
        'id' => $p['id'],
        'nom' => $p['nom'],
        'prix' => (float)$p['prix'],
        'qte' => $qte
    ];
}

header('Location: panier.php');
exit;
?>
