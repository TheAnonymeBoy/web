<?php
require_once './../phplogin.php';
session_start();

$errors = [];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $pseudo = trim($_POST['pseudo'] ?? '');
    $password = $_POST['password'] ?? '';

    if ($pseudo === '' || $password === '') {
        $errors[] = 'Pseudo et mot de passe requis.';
    } else {
        $stmt = $pdo->prepare('SELECT id, pseudo, password, nom, prenom, is_admin, banned FROM users WHERE pseudo = ? LIMIT 1');
        $stmt->execute([$pseudo]);
        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        if (!$user || !password_verify($password, $user['password'])) {
            $errors[] = 'Pseudo ou mot de passe invalide.';
        } else {
            if ((int)$user['banned'] === 1) {
                $errors[] = 'Compte ban';
            } else {
                $_SESSION['user'] = [
                    'id' => (int)$user['id'],
                    'pseudo' => $user['pseudo'],
                    'nom' => $user['nom'],
                    'prenom' => $user['prenom'],
                    'is_admin' => (int)$user['is_admin']
                ];
                header('Location: ./../index.php');
                exit;
            }
        }
    }
}
?>
<!doctype html>
<html lang="fr">
<head>
    <link rel="stylesheet" href="./../css/login.css">
  <meta charset="utf-8">
  <title>Connexion</title>
  <meta name="viewport" content="width=device-width,initial-scale=1">
  <style></style>
</head>
<body>
  <div class="login">
  <h1>Connexion</h1>
    <?php if (isset($_GET['registered'])): ?>
      <div style="background:#e6ffea;padding:1rem;border:1px solid #cceacc;">Inscription réussie — connectez-vous.</div>
    <?php endif; ?>
    <?php if (!empty($errors)): ?>
      <div style="background:#ffe6e6;padding:1rem;border:1px solid #ffcccc;">
        <ul><?php foreach($errors as $e) echo '<li>'.htmlspecialchars($e).'</li>'; ?></ul>
      </div>
    <?php endif; ?>
    <form method="post" action="login.php" autocomplete="off">
      <label>Pseudo <input name="pseudo" required></label>
      <label>Mot de passe <input name="password" type="password" required></label>
      <button type="submit" style="margin-top:1rem;padding:.5rem 1rem;">Se connecter</button>
    </form>
    <p>Pas encore inscrit ? <a href="register.php">Créer un compte</a></p>
    </div>
  
</body>
</html>
