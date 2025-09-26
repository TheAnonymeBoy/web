<?php
require_once './../phplogin.php';
session_start();

$user = $_SESSION['user'] ?? null;

if (!$user) {
    header('Location: ./login.php');
    exit;
}

$user_id = (int) $user['id'];


$stmt = $pdo->prepare("DELETE FROM users WHERE id = ?");
$stmt->execute([$user_id]);


session_unset();
session_destroy();

header('Location: ./../index.php'); 
exit;
