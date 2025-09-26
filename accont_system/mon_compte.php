<?php
require_once './../phplogin.php';
session_start();

if (!isset($_SESSION['user'])) {
    header('Location: auth/login.php');
    exit;
}

$user = $_SESSION['user'];
$success = $_GET['deleted'] ?? false;
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <link rel="stylesheet" href="./../css/moncompte.css">
    <meta charset="UTF-8">
    <title>Mon compte</title>
</head>
<body>
 

    <?php if ($success): ?>
        <p>
            Votre compte a été supprimé.
        </p>
    <?php endif; ?>

<div class="grib"> 
    <div class="card">
        <div class="return">
            <a href="./../index.php">←</a>
       </div>
        <h1>Mon compte</h1>
        <p><strong>Pseudo :</strong> <?php echo htmlspecialchars($user['pseudo']); ?></p>
        <div class="card2">
            <img src="./../img/icon.jpg">
            <p><strong></strong> <?php echo htmlspecialchars($user['nom']); ?>, </p>
            <p><strong></strong> <?php echo htmlspecialchars($user['prenom']); ?></p> 
        </div>
    <form method="post" action="supprimer_compte.php" onsubmit="return confirm('Voulez-vous vraiment supprimer votre compte ? Cette action est irréversible.')">
        <button type="submit" style="background-color:red; color:white; padding:0.5rem 1rem; border:none; cursor:pointer;">
            Supprimer mon compte
        </button>
    </form>
    </div>

  
</div>
  
</body>
</html>
