<?php
session_start();
// Vérification simple : seul l'admin peut ajouter
if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    die("Accès refusé.");
}
require_once 'config/db.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $stmt = $pdo->prepare("INSERT INTO talents (titre, description, url_contenu, type_contenu) VALUES (?, ?, ?, ?)");
    $stmt->execute([$_POST['titre'], $_POST['description'], $_POST['url'], $_POST['type']]);
    $msg = "Contenu ajouté avec succès !";
}
?>
<form method="POST" class="container mt-4">
    <input type="text" name="titre" placeholder="Titre" class="form-control mb-2" required>
    <textarea name="description" placeholder="Description" class="form-control mb-2"></textarea>
    <input type="text" name="url" placeholder="Lien (URL YouTube ou lien jeu)" class="form-control mb-2" required>
    <select name="type" class="form-select mb-2">
        <option value="video">Vidéo</option>
        <option value="jeu">Jeu</option>
    </select>
    <button type="submit" class="btn btn-success">Publier</button>
</form>