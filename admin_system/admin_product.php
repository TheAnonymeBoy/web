<?php
require_once './../phplogin.php';
session_start();

// Sécurité : vérifier que l'utilisateur est admin
$user = $_SESSION['user'] ?? null;
if (!$user || empty($user['is_admin'])) {
    http_response_code(403);
    exit('Accès refusé');
}

// Récupération des catégories
$categories = $pdo->query("SELECT * FROM categories ORDER BY nom")->fetchAll();

// Traitement ajout de produit
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nom = trim($_POST['nom'] ?? '');
    $description = trim($_POST['description'] ?? '');
    $prix = floatval($_POST['prix'] ?? 0);
    $categorie_id = isset($_POST['categorie_id']) ? (int)$_POST['categorie_id'] : 0;

    if ($nom && $prix > 0 && $categorie_id > 0) {
        $stmt = $pdo->prepare("INSERT INTO produits (nom, description, prix, categorie_id) VALUES (?, ?, ?, ?)");
        $stmt->execute([$nom, $description, $prix, $categorie_id]);
        header('Location: admin_product.php');
        exit;
    }
}

// Traitement suppression
if (isset($_GET['delete'])) {
    $id = (int)$_GET['delete'];
    $stmt = $pdo->prepare("DELETE FROM produits WHERE id = ?");
    $stmt->execute([$id]);
    header('Location: admin_product.php');
    exit;
}

// Récupération des produits
$products = $pdo->query("
    SELECT p.*, c.nom AS categorie_nom
    FROM produits p
    LEFT JOIN categories c ON p.categorie_id = c.id
    ORDER BY p.id ASC
")->fetchAll();
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Gestion des produits</title>
    <style>
        body { font-family: Arial, sans-serif; padding: 2rem; background-color: #f9f9f9; }
        h1, h2 { color: #333; }
        table { width: 100%; border-collapse: collapse; margin-top: 1rem; background: #fff; }
        th, td { border: 1px solid #ccc; padding: 0.75rem; text-align: left; }
        th { background-color: #f0f0f0; }
        form { background: #fff; padding: 1rem; border-radius: 5px; max-width: 600px; margin-top: 1rem; }
        label { display: block; margin-top: 0.5rem; }
        input, select, textarea { width: 100%; padding: 0.5rem; margin-top: 0.25rem; }
        button { margin-top: 1rem; padding: 0.5rem 1rem; }
        .actions a { color: red; text-decoration: none; }
        .actions a:hover { text-decoration: underline; }
        .back { margin-bottom: 1rem; display: inline-block; }
    </style>
</head>
<body>

<h1>Gestion des produits</h1>
<a class="back" href="admin.php">← Retour au panneau admin</a>

<h2>Ajouter un produit</h2>
<form method="post">
    <label>
        Nom :
        <input type="text" name="nom" required>
    </label>

    <label>
        Description :
        <textarea name="description" rows="3"></textarea>
    </label>

    <label>
        Prix (€) :
        <input type="number" name="prix" min="0.01" step="0.01" required>
    </label>

    <label>
        Catégorie :
        <select name="categorie_id" required>
            <option value="">-- Choisir une catégorie --</option>
            <?php foreach ($categories as $cat): ?>
                <option value="<?= $cat['id'] ?>"><?= htmlspecialchars($cat['nom'] ?? '') ?></option>
            <?php endforeach; ?>
        </select>
    </label>

    <button type="submit">Ajouter</button>
</form>

<h2>Produits existants</h2>
<table>
    <thead>
        <tr>
            <th>ID</th>
            <th>Nom</th>
            <th>Description</th>
            <th>Prix</th>
            <th>Catégorie</th>
            <th>Action</th>
        </tr>
    </thead>
    <tbody>
        <?php if (empty($products)): ?>
            <tr><td colspan="6">Aucun produit trouvé.</td></tr>
        <?php else: ?>
            <?php foreach ($products as $p): ?>
                <tr>
                    <td><?= (int)$p['id'] ?></td>
                    <td><?= htmlspecialchars($p['nom'] ?? '') ?></td>
                    <td><?= htmlspecialchars($p['description'] ?? '') ?></td>
                    <td><?= number_format($p['prix'], 2, ',', ' ') ?> €</td>
                    <td><?= htmlspecialchars($p['categorie_nom'] ?? 'Non catégorisé') ?></td>
                    <td class="actions">
                        <a href="?delete=<?= $p['id'] ?>" onclick="return confirm('Supprimer ce produit ?');">Supprimer</a>
                    </td>
                </tr>
            <?php endforeach; ?>
        <?php endif; ?>
    </tbody>
</table>

</body>
</html>

