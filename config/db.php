<?php
$host = 'localhost';
$db   = 'school_tech_butembo'; // Vérifiez que c'est bien le nom de votre base dans phpMyAdmin
$user = 'root';
$pass = ''; // Sur Wamp, le mot de passe est vide par défaut
$charset = 'utf8mb4';

$dsn = "mysql:host=$host;dbname=$db;charset=$charset";

try {
     $pdo = new PDO($dsn, $user, $pass);
     $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (\PDOException $e) {
     echo "Erreur de connexion : " . $e->getMessage();
}
?>