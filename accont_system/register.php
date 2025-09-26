<?php
require_once './../phplogin.php';
session_start();

$erreurs = [];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nom = trim($_POST['nom'] ?? '');
    $prenom = trim($_POST['prenom'] ?? '');
    $pseudo = trim($_POST['pseudo'] ?? '');
    $password = $_POST['password'] ?? '';

    if ($nom === '' || $prenom === '' || $pseudo === '' || $password === '') {
        $erreurs[] = 'Tous les champs sont requis.';
    }

    if (strlen($pseudo) > 50) {
        $erreurs[] = 'Le pseudo est trop long (max 50 caractères).';
    }

    if (strlen($password) < 4) {
        $erreurs[] = 'Le mot de passe doit contenir au moins 4 caractères.';
    }

    if (empty($erreurs)) {
        $stmt = $pdo->prepare('SELECT id FROM users WHERE pseudo = ? LIMIT 1');
        $stmt->execute([$pseudo]);
        if ($stmt->fetch()) {

            $stmt2 = $pdo->prepare('SELECT banned FROM users WHERE pseudo = ? LIMIT 1');
            $stmt2->execute([$pseudo]);
            $row = $stmt2->fetch(PDO::FETCH_ASSOC);
            if ($row && (int)$row['banned'] === 1) {
                $errors[] = 'Compte ban';
            } else {
                $errors[] = 'Ce pseudo est déjà utilisé.';
            }
        } else {
            $hash = password_hash($password, PASSWORD_DEFAULT);
            $stmt = $pdo->prepare('INSERT INTO users (nom, prenom, pseudo, password) VALUES (?, ?, ?, ?)');
            $stmt->execute([$nom, $prenom, $pseudo, $hash]);
            header('Location: login.php?registered=1');
            exit;
        }
    }
}
?>
<!doctype html>
<html lang="fr">
<head>
    <link rel="stylesheet" href="./../css/register.css">
  <meta charset="utf-8">
  <title>Inscription</title>
  <meta name="viewport" content="width=device-width,initial-scale=1">
  
</head>
<body>
  <div class="register">
  <h1>Créer un compte</h1>
  <?php if (!empty($errors)): ?>
    <div style="background:#ffe6e6;padding:1rem;border:1px solid #ffcccc;">
      <ul><?php foreach($errors as $e) echo '<li>'.htmlspecialchars($e).'</li>'; ?></ul>
    </div>
  <?php endif; ?>
  <form method="post" action="register.php" autocomplete="off">
    <label>Nom <input name="nom" required maxlength="100"></label>
    <label>Prénom <input name="prenom" required maxlength="100"></label>
    <label>Pseudo <input name="pseudo" required maxlength="50"></label>
    <label>Mot de passe <input name="password" type="password" required></label>
    <button type="submit" style="margin-top:1rem;padding:.5rem 1rem;">S'inscrire</button>
  </form>
  <p>Déjà inscrit ? <a href="login.php">Se connecter</a></p>
  </div>
</body>
</html>
