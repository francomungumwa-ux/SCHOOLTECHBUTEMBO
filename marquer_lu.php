<?php
// Utilisation du chemin absolu pour éviter les erreurs
require_once 'config/db.php'; 

if (isset($_GET['id'])) {
    $id = (int)$_GET['id'];
    
    // Mise à jour : on met '1' ou 'lu' dans la colonne 'lu' 
    // (vérifie si tu stockes 'lu' ou 1 dans ta base)
    $stmt = $pdo->prepare("UPDATE messages SET lu = 'lu' WHERE id = ?");
    $stmt->execute([$id]);
}

// Redirection vers la page précédente
header('Location: ' . $_SERVER['HTTP_REFERER']);
exit();
?>