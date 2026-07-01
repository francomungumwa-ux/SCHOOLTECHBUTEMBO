<?php
session_start();
require_once 'config/db.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // 1. Validation de l'ID de l'école
    $ecole_id = isset($_POST['ecole_id']) ? (int)$_POST['ecole_id'] : 0;
    
    // 2. Nettoyage du message
    $message_brut = isset($_POST['message']) ? trim($_POST['message']) : '';
    $message = htmlspecialchars($message_brut, ENT_QUOTES, 'UTF-8');
    
    // 3. Détermination et nettoyage de l'auteur
    $auteur_brut = isset($_SESSION['user_name']) ? $_SESSION['user_name'] : (isset($_POST['nom_visiteur']) ? $_POST['nom_visiteur'] : 'Anonyme');
    $auteur = htmlspecialchars(trim($auteur_brut), ENT_QUOTES, 'UTF-8');

    // 4. Insertion sécurisée dans la base de données
    if (!empty($message) && $ecole_id > 0) {
        $stmt = $pdo->prepare("INSERT INTO messages (ecole_id, message, auteur, date_envoi) VALUES (?, ?, ?, NOW())");
        if ($stmt->execute([$ecole_id, $message, $auteur])) {
            echo "success";
        } else {
            // Log erreur si nécessaire
            echo "error";
        }
    }
}
?>