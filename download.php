<?php
require_once 'config/db.php';

// Vérification stricte de l'ID
if (isset($_GET['id']) && !empty($_GET['id'])) {
    $id = (int)$_GET['id'];

    // 1. Mise à jour du compteur
    $stmt = $pdo->prepare("UPDATE ressources SET telechargements = telechargements + 1 WHERE id = ?");
    $stmt->execute([$id]);

    // 2. Récupération de l'URL
    $stmt = $pdo->prepare("SELECT url_fichier FROM ressources WHERE id = ?");
    $stmt->execute([$id]);
    $file = $stmt->fetch();

    if ($file && !empty($file['url_fichier'])) {
        // Redirection vers le fichier
        header("Location: " . $file['url_fichier']);
        exit();
    } else {
        die("Erreur : Ce fichier n'existe pas dans la base de données.");
    }
} else {
    die("Erreur : Aucun ID de fichier fourni.");
}
?>