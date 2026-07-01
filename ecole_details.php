<?php
// On s'assure que la session est démarrée
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
require_once 'config/db.php';

$id_ecole = isset($_GET['id']) ? (int)$_GET['id'] : 0;

if ($id_ecole > 0) {
    // On vérifie si cette école a déjà été vue dans la session actuelle
    if (!isset($_SESSION['vues_ecoles'][$id_ecole])) {
        // Incrémenter les vues seulement si c'est la première fois dans cette session
        $stmt = $pdo->prepare("UPDATE ecoles SET vues = vues + 1 WHERE id = ?");
        $stmt->execute([$id_ecole]);
        
        // On enregistre dans la session pour ne plus incrémenter
        $_SESSION['vues_ecoles'][$id_ecole] = true;
    }

    // Récupérer les infos de l'école
    $stmt = $pdo->prepare("SELECT * FROM ecoles WHERE id = ?");
    $stmt->execute([$id_ecole]);
    $ecole = $stmt->fetch();
    
    // Sécurité : si l'école n'existe pas
    if (!$ecole) {
        die("École introuvable.");
    }
}
?>