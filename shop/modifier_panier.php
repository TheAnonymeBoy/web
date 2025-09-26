<?php
session_start();
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: <div class="">panier.php');
    exit;
}

$action = $_POST['action'] ?? '';
$id = (int)($_POST['id'] ?? 0);

if (!isset($_SESSION['panier'])) {
    $_SESSION['panier'] = [];
}

switch ($action) {
    case 'plus':
        if (isset($_SESSION['panier'][$id])) {
            $_SESSION['panier'][$id]['qte'] += 1;
        }
        break;
    case 'moins':
        if (isset($_SESSION['panier'][$id])) {
            $_SESSION['panier'][$id]['qte'] -= 1;
            if ($_SESSION['panier'][$id]['qte'] <= 0) {
                unset($_SESSION['panier'][$id]);
            }
        }
        break;
    case 'supprimer':
        if (isset($_SESSION['panier'][$id])) {
            unset($_SESSION['panier'][$id]);
        }
        break;
    case 'vider':
        $_SESSION['panier'] = [];
        break;
}

header('Location: ./panier.php');
exit;
?>