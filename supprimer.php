<?php
session_start();
require_once 'config/db.php';

if (!isset($_SESSION['user_id'])) { die("Accès refusé."); }

$id_labo = $_GET['id'] ?? 0;
$stmt = $pdo->prepare("SELECT id_ecole FROM laboratoires WHERE id = ?");
$stmt->execute([$id_labo]);
$labo = $stmt->fetch();

// Vérification : Admin système ou Propriétaire du labo
if ($_SESSION['role'] === 'admin' || ($_SESSION['user_id'] == $labo['id_ecole'])) {
    $pdo->prepare("DELETE FROM laboratoires WHERE id = ?")->execute([$id_labo]);
    header("Location: index.php?msg=supprime");
} else {
    echo "Vous n'avez pas la permission de supprimer ce laboratoire.";
}
?>