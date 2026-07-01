<?php
require_once 'config/db.php';

// Vérification de sécurité pour l'ID
if (!isset($_GET['ecole_id'])) {
    die("Erreur : ID de l'école manquant.");
}

$ecole_id = (int)$_GET['ecole_id'];

// On récupère les messages de manière sécurisée
$stmt = $pdo->prepare("SELECT auteur, message, date_envoi FROM messages WHERE ecole_id = ? ORDER BY date_envoi ASC");
$stmt->execute([$ecole_id]);

while ($row = $stmt->fetch()) {
    // Nettoyage des données pour l'affichage (Sécurité XSS)
    $auteur_brut = htmlspecialchars($row['auteur'], ENT_QUOTES, 'UTF-8');
    $message_propre = htmlspecialchars($row['message'], ENT_QUOTES, 'UTF-8');
    $date = date("H:i", strtotime($row['date_envoi']));
    
    // Logique pour différencier l'expéditeur
    // Note : Si l'auteur est l'institution, on affiche 'Institution'
    $is_institution = ($row['auteur'] === 'institution' || $row['auteur'] === 'ecole');
    $classe = $is_institution ? 'text-primary' : 'text-dark';
    $nom_affichage = $is_institution ? 'Institution' : $auteur_brut;
    
    echo "<div class='mb-3 $classe'>";
    echo "<strong>" . $nom_affichage . " :</strong> " . $message_propre;
    echo " <br><small class='text-muted'><em>" . $date . "</em></small>";
    echo "</div>";
}
?>