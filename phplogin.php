<head>
    <link rel="stylesheet" href="">
</head>
<?php
$db_host = 'localhost';
$db_name = 'ecommerce_db';
$db_user = 'root';
$db_pass = '';

$dsn = "mysql:host=$db_host;dbname=$db_name;charset=utf8mb4";


$options = [
    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
    PDO::ATTR_EMULATE_PREPARES => false,
];

try {
    $pdo = new PDO($dsn, $db_user, $db_pass, $options);
} catch (PDOException $e) {
    exit('Database connection failed: ' . $e->getMessage());
}
// pdo db pour data base

?>
<!-- pour initialisée (new mysqli('localhost', 'root', '', 'ecommerce_db'))->multi_query(file_get_contents('init.sql'));
maintenant trouvée comment faire fonctionéne  -->