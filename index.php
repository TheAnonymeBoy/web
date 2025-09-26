<?php
require_once './phplogin.php';
session_start();


$user = isset($_SESSION['user']) && is_array($_SESSION['user']) ? $_SESSION['user'] : null;

$categories = $pdo->query("SELECT * FROM categories")->fetchAll(PDO::FETCH_ASSOC);

$selectedCategory = isset($_GET['cat']) ? (int)$_GET['cat'] : 0;

try {
    if ($selectedCategory > 0) {
        $stmt = $pdo->prepare("SELECT id, nom, description, prix FROM produits WHERE categorie_id = ? ORDER BY id ASC");
        $stmt->execute([$selectedCategory]);
    } else {
        $stmt = $pdo->query("SELECT id, nom, description, prix FROM produits ORDER BY id ASC");
    }
    $products = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
   
    die("Erreur lors de la récupération des produits : " . $e->getMessage());
}
?>
<!doctype html>
<html lang="fr">
<head>
    <meta charset="utf-8">
    <title>Boutique électronique</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="./css/index.css">
</head>
<body>
<header>
    <h1>Boutique électronique</h1>
    <nav>
        <?php if ($user): ?>
            <span>Bonjour, <?= htmlspecialchars($user['pseudo']) ?></span>
            <a href="./shop/panier.php" class="cart-link">
                Panier (<?= array_sum(array_column($_SESSION['panier'] ?? [], 'qte')) ?: 0 ?>)
            </a>
            <a href="./accont_system/mon_compte.php">Mon compte</a>
            <a href="./accont_system/logout.php">Se déconnecter</a>

            <?php if (!empty($user['is_admin'])): ?>
                <a href="./admin_system/admin.php">Administration</a>
            <?php endif; ?>
        <?php else: ?>
            <a href="./accont_system/login.php">Se connecter</a>
            <a href="./accont_system/register.php">S'inscrire</a>
        <?php endif; ?>
    </nav>
</header>

<div class="container">

    <div class="filters" style="margin: 1em 0;">
        <form method="get" style="display: inline-block;">
            <label for="cat">Filtrer par catégorie :</label>
            <select name="cat" id="cat" onchange="this.form.submit()">
                <option value="0">-- Toutes les catégories --</option>
                <?php foreach ($categories as $cat): ?>
                    <option value="<?= $cat['id'] ?>" <?= ($selectedCategory == $cat['id']) ? 'selected' : '' ?>>
                        <?= htmlspecialchars($cat['nom']) ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </form>
    </div>

    <h2>Produits disponibles</h2>
    <div class="grid">
        <?php if (count($products) > 0): ?>
            <?php foreach ($products as $p): ?>
                <div class="card">
                    <h3><?= htmlspecialchars($p['nom']) ?></h3>
                    <p><?= htmlspecialchars($p['description']) ?></p>
                    <p class="price"><?= number_format($p['prix'], 2, ',', ' ') ?> €</p>
                    <div class="actions">
                        <form method="post" action="./shop/ajouter_panier.php" style="margin:0;">
                            <input type="hidden" name="id" value="<?= (int)$p['id'] ?>">
                            <label style="display:inline-block">
                                Quantité <input type="number" name="qte" value="1" min="1" style="width:60px;">
                            </label>
                            <button type="submit" class="btn">Ajouter au panier</button>
                        </form>
                    </div>
                </div>
            <?php endforeach; ?>
        <?php else: ?>
            <p>Aucun produit trouvé dans cette catégorie.</p>
        <?php endif; ?>
    </div>
</div>
</body>
</html>

</html>
