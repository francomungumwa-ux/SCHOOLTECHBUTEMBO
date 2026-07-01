<?php
// logout.php
session_start(); // On démarre la session pour pouvoir y accéder

// 1. On vide le tableau $_SESSION
$_SESSION = array();

// 2. On détruit la session dans le serveur
session_destroy();

// 3. On redirige vers la page de connexion
header("Location: login.php");
exit();
?>