<?php
require_once './../phplogin.php';
session_start();

$user = $_SESSION['user'] ?? null;

// Vérifier que l'utilisateur est connecté et admin
if (!$user) {
    header('Location: ./../accont_system/login.php');
    exit;
}
if (empty($user['is_admin'])) {
    http_response_code(403);
    exit('Accès refusé');
}

// Vérifier l'ID de commande
$order_id = isset($_GET['id']) ? (int)$_GET['id'] : 0;
if ($order_id <= 0) {
    exit('ID de commande invalide.');
}

// Récupérer la commande et l'utilisateur
$stmt = $pdo->prepare("
    SELECT o.id, o.total, o.created_at, u.pseudo 
    FROM orders o
    LEFT JOIN users u ON o.user_id = u.id
    WHERE o.id = ?
");
$stmt->execute([$order_id]);
$order = $stmt->fetch();

if (!$order) {
    exit('Commande introuvable.');
}

// Récupérer les articles commandés
$stmt_items = $pdo->prepare("
    SELECT 
        oi.quantity, 
        p.nom AS produit_nom, 
        p.prix AS produit_prix
    FROM order_items oi
    LEFT JOIN produits p ON oi.product_id = p.id
    WHERE oi.order_id = ?
");
$stmt_items->execute([$order_id]);
$items = $stmt_items->fetchAll();
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Détails commande #<?= htmlspecialchars($order['id']) ?></title>
    <style>
        body { font-family: Arial, sans-serif; background-color: #f4f4f4; margin: 0; padding: 2rem; }
        .container { background-color: #fff; padding: 2rem; border-radius: 8px; max-width: 800px; margin: auto; }
        h1 { margin-top: 0; }
        table { width: 100%; border-collapse: collapse; margin-top: 1rem; }
        th, td { border: 1px solid #ccc; padding: 0.75rem; text-align: left; }
        th { background-color: #f0f0f0; }
        .back-link { margin-top: 1rem; display: inline-block; text-decoration: none; color: #0066cc; }
        .back-link:hover { text-decoration: underline; }
    </style>
</head>
<body>

<div class="container">
    <h1>Commande #<?= htmlspecialchars($order['id']) ?></h1>

    <p><strong>Client :</strong> <?= htmlspecialchars($order['pseudo']) ?></p>
    <p><strong>Date :</strong> <?= htmlspecialchars($order['created_at']) ?></p>
    <p><strong>Total :</strong> <?= number_format($order['total'], 2, ',', ' ') ?> €</p>

    <h2>Produits</h2>

    <?php if (empty($items)): ?>
        <p>Aucun produit dans cette commande.</p>
    <?php else: ?>
        <table>
            <thead>
                <tr>
                    <th>Produit</th>
                    <th>Prix unitaire</th>
                    <th>Quantité</th>
                    <th>Total</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($items as $item): ?>
                    <tr>
                        <td><?= htmlspecialchars($item['produit_nom'] ?? 'Produit supprimé') ?></td>
                        <td>
                            <?= isset($item['produit_prix']) 
                                ? number_format($item['produit_prix'], 2, ',', ' ') . ' €'
                                : '—' ?>
                        </td>
                        <td><?= (int)$item['quantity'] ?></td>
                        <td>
                            <?php
                                if (isset($item['produit_prix'])) {
                                    $totalProduit = $item['produit_prix'] * $item['quantity'];
                                    echo number_format($totalProduit, 2, ',', ' ') . ' €';
                                } else {
                                    echo '—';
                                }
                            ?>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    <?php endif; ?>

    <a class="back-link" href="admin.php">← Retour à l'administration</a>
</div>

</body>
</html>
