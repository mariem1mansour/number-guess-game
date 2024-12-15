<?php
$host = 'localhost';
$db = 'number_guess_game';
$user = 'root';
$pass = '';
//Le jeu de caractères
// version améliorée de UTF-8, qui supporte les emojis et d'autres caractères spéciaux:
$charset = 'utf8mb4';  
//une chaîne qui indique à PHP comment se connecter à la base de données.
$dsn = "mysql:host=$host;dbname=$db;charset=$charset";
$options = [
//Définit le mode de gestion des erreurs. Ici, les erreurs sont lancées sous forme d'exception (meilleure pratique pour le débogage)
    PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
//Définit le mode de récupération des données, signifie que les résultats des requêtes seront renvoyés sous forme de tableau associatif (clés correspondant aux noms des colonnes)    
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
    PDO::ATTR_EMULATE_PREPARES   => false,
];

try {
//Crée un nouvel objet PDO (PHP Data Object) pour se connecter à la base de données
    $pdo = new PDO($dsn, $user, $pass, $options);
} catch (\PDOException $e) {
    throw new \PDOException($e->getMessage(), (int)$e->getCode());
}
?>
