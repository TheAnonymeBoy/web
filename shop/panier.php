<?php
require_once './../phplogin.php';
session_start();

$user = $_SESSION['user'] ?? null;
$panier = $_SESSION['panier'] ?? [];

// Fonction pour calculer le total
function total_panier($panier) {
    $total = 0.0;
    foreach ($panier as $item) {
        $total += $item['prix'] * $item['qte'];
    }
    return $total;
}
?>
<!doctype html>
<html lang="fr">
<head>
    <meta charset="utf-8">
    <title>Mon panier</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="./../css/panier.css">
    <style>
        body { font-family: Arial, sans-serif; padding: 2rem; background: #f4f4f4; }
        header { background: #333; color: #fff; padding: 1rem; display: flex; justify-content: space-between; align-items: center; }
        table { width: 100%; border-collapse: collapse; margin-top: 1rem; background: #fff; }
        th, td { border: 1px solid #ccc; padding: 0.75rem; text-align: center; }
        .btn { padding: 0.3rem 0.6rem; margin: 0 0.2rem; }
        .container { background: #fff; padding: 2rem; border-radius: 8px; }
        form { display: inline-block; }
        a { color: #0066cc; }
        p { margin-top: 1rem; }
    </style>
</head>
<body>

<header>
    <h1>Panier</h1>
    <nav><a href="./../index.php" style="color:#fff;text-decoration:none;">Retour à la boutique</a></nav>
</header>

<div class="container">
<?php if (empty($panier)): ?>
    <p>Votre panier est vide. <a href="./../index.php">Continuer les achats</a></p>
<?php else: ?>
    <table>
        <thead>
            <tr>
                <th>Produit</th>
                <th>Prix unitaire</th>
                <th>Quantité</th>
                <th>Sous-total</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($panier as $id => $item): ?>
                <tr>
                    <td><?= htmlspecialchars($item['nom']) ?></td>
                    <td><?= number_format($item['prix'], 2, ',', ' ') ?> €</td>
                    <td><?= (int)$item['qte'] ?></td>
                    <td><?= number_format($item['prix'] * $item['qte'], 2, ',', ' ') ?> €</td>
                    <td>
                        <form method="post" action="modifier_panier.php">
                            <input type="hidden" name="action" value="plus">
                            <input type="hidden" name="id" value="<?= (int)$id ?>">
                            <button class="btn" type="submit">+</button>
                        </form>
                        <form method="post" action="modifier_panier.php">
                            <input type="hidden" name="action" value="moins">
                            <input type="hidden" name="id" value="<?= (int)$id ?>">
                            <button class="btn" type="submit">-</button>
                        </form>
                        <form method="post" action="modifier_panier.php">
                            <input type="hidden" name="action" value="supprimer">
                            <input type="hidden" name="id" value="<?= (int)$id ?>">
                            <button class="btn" type="submit">Supprimer</button>
                        </form>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
        <tfoot>
            <tr>
                <th colspan="3">Total</th>
                <th colspan="2"><?= number_format(total_panier($panier), 2, ',', ' ') ?> €</th>
            </tr>
        </tfoot>
    </table>

    <p>
        <form method="post" action="modifier_panier.php" style="display:inline-block;">
            <input type="hidden" name="action" value="vider">
            <button class="btn" type="submit">Vider le panier</button>
        </form>

        <?php if ($user): ?>
            <form method="post" action="valider_commande.php" style="display:inline-block;">
                <button class="btn" type="submit">Valider la commande</button>
            </form>
        <?php else: ?>
            <p style="margin-top:1rem; color: red;">
                Vous devez <a href="./../login.php">vous connecter</a> ou <a href="./../register.php">créer un compte</a> pour valider la commande.
            </p>
        <?php endif; ?>
    </p>
<?php endif; ?>
</div>

</body>
</html>
