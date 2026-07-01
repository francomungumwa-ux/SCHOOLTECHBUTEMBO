<?php
// auth.php
session_start();
require_once 'config/db.php';

// Vérification si les données sont envoyées
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST['email'];
    $password = $_POST['password'];

    // Préparation de la requête pour récupérer l'utilisateur
    $stmt = $pdo->prepare("SELECT * FROM utilisateurs WHERE email = ?");
    $stmt->execute([$email]);
    $user = $stmt->fetch();

    // Vérification du mot de passe et de l'existence de l'utilisateur
    if ($user && password_verify($password, $user['mot_de_passe'])) {
        // Initialisation des variables de session
        $_SESSION['user_id'] = $user['id'];
        $_SESSION['role'] = $user['role'];
        $_SESSION['ecole_id'] = $user['ecole_id']; // <-- Lien vital avec l'école
        
        // Redirection vers le tableau de bord
        header("Location: index.php");
        exit();
    } else {
        // En cas d'erreur, on reste sur la page ou on affiche un message
        echo "Identifiants incorrects. <a href='login.php'>Retour</a>";
    }
} else {
    // Si l'utilisateur tente d'accéder directement au fichier sans formulaire
    header("Location: login.php");
    exit();
}
?>