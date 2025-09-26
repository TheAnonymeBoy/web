<?php
require_once './../phplogin.php';
session_start();

$user = $_SESSION['user'] ?? null;
if (!$user || empty($user['is_admin'])) {
    header('HTTP/1.1 403 Forbidden');
    echo 'Accès refusé. Vous devez être administrateur.';
    exit;
}

$action = $_GET['action'] ?? '';
$target = (int)($_GET['id'] ?? 0);

if ($action === 'ban' && $target > 0) {
    $pdo->prepare('UPDATE users SET banned = 1 WHERE id = ?')->execute([$target]);
    header('Location: admin.php');
    exit;
} elseif ($action === 'unban' && $target > 0) {
    $pdo->prepare('UPDATE users SET banned = 0 WHERE id = ?')->execute([$target]);
    header('Location: admin.php');
    exit;
} elseif ($action === 'delete' && $target > 0) {

    $pdo->prepare('DELETE FROM order_items WHERE order_id IN (SELECT id FROM orders WHERE user_id = ?)')->execute([$target]);
    $pdo->prepare('DELETE FROM orders WHERE user_id = ?')->execute([$target]);
    $pdo->prepare('DELETE FROM users WHERE id = ?')->execute([$target]);
    header('Location: admin.php');
    exit;
} elseif ($action === 'delete_order' && $target > 0) {

    $pdo->prepare('DELETE FROM order_items WHERE order_id = ?')->execute([$target]);
    $pdo->prepare('DELETE FROM orders WHERE id = ?')->execute([$target]);
    header('Location: admin.php');
    exit;
}


$users = $pdo->query('SELECT id, pseudo, nom, prenom, created_at, is_admin, banned FROM users ORDER BY id ASC')->fetchAll(PDO::FETCH_ASSOC);
$orders = $pdo->query('SELECT o.id, o.user_id, o.total, o.created_at, u.pseudo FROM orders o LEFT JOIN users u ON o.user_id = u.id ORDER BY o.created_at DESC')->fetchAll(PDO::FETCH_ASSOC);
?>

<!doctype html>
<html lang="fr">
<head>
  <meta charset="utf-8">
  <title>administrateur</title>
  <style>
    table { border-collapse: collapse; width: 100%; }
    th, td { border: 1px solid #ddd; padding: .5rem; text-align: left; }
    a { text-decoration: none; color: blue; }
    .btn { margin-top: 1rem; display: inline-block; background: #333; color: #fff; padding: .5rem 1rem; }
  </style>
</head>
<body>
  <h1>Panel administrateur</h1>
  <p>Connecté en tant que <?php echo htmlspecialchars($user['pseudo']); ?> — <a href="./../index.php">Retour à la boutique</a></p>

  <h2>Utilisateurs</h2>
  <table>
    <thead>
      <tr>
        <th>ID</th><th>Pseudo</th><th>Nom</th><th>Prénom</th><th>Admin</th><th>Banni</th><th>Actions</th>
      </tr>
    </thead>
    <tbody>
    <?php foreach($users as $u): ?>
      <tr>
        <td><?php echo (int)$u['id']; ?></td>
        <td><?php echo htmlspecialchars($u['pseudo']); ?></td>
        <td><?php echo htmlspecialchars($u['nom']); ?></td>
        <td><?php echo htmlspecialchars($u['prenom']); ?></td>
        <td><?php echo $u['is_admin'] ? 'Oui' : 'Non'; ?></td>
        <td><?php echo $u['banned'] ? 'Oui' : 'Non'; ?></td>
        <td>
          <?php if (!$u['is_admin']): ?>
            <?php if (!$u['banned']): ?>
              <a href="admin.php?action=ban&id=<?php echo (int)$u['id']; ?>">Bannir</a>
            <?php else: ?>
              <a href="admin.php?action=unban&id=<?php echo (int)$u['id']; ?>">Réhabiliter</a>
            <?php endif; ?>
            &nbsp;|&nbsp;
            <a href="admin.php?action=delete&id=<?php echo (int)$u['id']; ?>" onclick="return confirm('Supprimer cet utilisateur ? Cette action est irréversible.');">Supprimer</a>
          <?php else: ?>
            (Admin)
          <?php endif; ?>
        </td>
      </tr>
    <?php endforeach; ?>
    </tbody>
  </table>

  <h2>Commandes</h2>
  <?php if (count($orders) === 0): ?>
    <p>Aucune commande pour le moment.</p>
  <?php else: ?>
    <table>
      <thead>
        <tr><th>ID</th><th>Pseudo</th><th>Total</th><th>Date</th><th>Actions</th></tr>
      </thead>
      <tbody>
        <?php foreach($orders as $o): ?>
          <tr>
            <td><?php echo (int)$o['id']; ?></td>
            <td><?php echo htmlspecialchars($o['pseudo'] ?? ''); ?></td>
            <td><?php echo number_format($o['total'], 2, ',', ' '); ?> €</td>
            <td><?php echo htmlspecialchars($o['created_at']); ?></td>
            <td>
              <a href="admin_view_order.php?id=<?php echo (int)$o['id']; ?>">Voir</a>
              &nbsp;|&nbsp;
              <a href="admin.php?action=delete_order&id=<?php echo (int)$o['id']; ?>" onclick="return confirm('Supprimer cette commande ?');">Supprimer</a>
            </td>
          </tr>
        <?php endforeach; ?>
      </tbody>
    </table>
  <?php endif; ?>

  <h2>Produits</h2>
  <p><a class="btn" href="./admin_product.php">Gérer les produits (ajouter/supprimer)</a></p>
</body>
</html>
