<?php
session_start();
require_once 'config/db.php';

// Vérification de sécurité
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$message = "";

// Traitement du formulaire
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $titre = htmlspecialchars($_POST['titre']);
    $type = htmlspecialchars($_POST['type']);
    $categorie = htmlspecialchars($_POST['categorie']);
    $description = htmlspecialchars($_POST['description']);
    $origine = $_POST['type_source'];
    $auteur_id = $_SESSION['user_id'];
    $url_finale = "";

    // Gestion du fichier ou de l'URL
    if ($origine == 'upload' && isset($_FILES['fichier_local']) && $_FILES['fichier_local']['error'] == 0) {
        $dossier = "uploads/";
        if (!is_dir($dossier)) mkdir($dossier, 0777, true);
        $url_finale = $dossier . time() . '_' . basename($_FILES['fichier_local']['name']);
        move_uploaded_file($_FILES['fichier_local']['tmp_name'], $url_finale);
    } else {
        $url_finale = htmlspecialchars($_POST['url_fichier']);
    }

    // Insertion dans la base
    $sql = "INSERT INTO ressources (titre, type, categorie, url_fichier, description, auteur_id, origine_contenu, date_ajout) VALUES (?, ?, ?, ?, ?, ?, ?, NOW())";
    $stmt = $pdo->prepare($sql);
    if ($stmt->execute(array($titre, $type, $categorie, $url_finale, $description, $auteur_id, $origine))) {
        $message = "<div class='alert alert-success'>Ressource publiée avec succès !</div>";
    }
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>School Tech Butembo - Publier</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<nav class="navbar navbar-expand-lg navbar-dark bg-primary shadow-sm mb-4">
    <div class="container">
        <a class="navbar-brand fw-bold" href="index.php">School Tech Butembo</a>
    </div>
</nav>

<main>
    <div class="container mt-5">
        <div class="col-md-8 mx-auto">
            <h2 class="mb-4 text-primary">Publier une ressource</h2>
            <?php echo $message; ?>
            
            <form method="POST" enctype="multipart/form-data" class="card p-4 shadow-sm border-0">
                <div class="mb-3">
                    <label class="form-label">Titre</label>
                    <input type="text" name="titre" class="form-control" required>
                </div>
                <div class="mb-3">
                    <label class="form-label">Catégorie</label>
                    <select name="categorie" class="form-select" required>
                        <option value="informatique_generale">Informatique Générale & Bureautique</option>
                        <option value="programmation">Initiation à la Programmation</option>
                        <option value="structure_ordinateur">Structure des Ordinateurs</option>
                    </select>
                </div>
                <div class="mb-3">
                    <label class="form-label">Type de contenu</label>
                    <select name="type" class="form-select">
                        <option value="cours">Cours</option>
                        <option value="video">Vidéo</option>
                        <option value="audio">Audio</option>
                    </select>
                </div>
                <div class="mb-3">
                    <label class="form-label">Source du contenu</label>
                    <select name="type_source" class="form-select" id="type_source" onchange="toggleInput()">
                        <option value="lien">Lien URL</option>
                        <option value="upload">Fichier local</option>
                    </select>
                </div>
                <div id="url_div" class="mb-3">
                    <label class="form-label">Lien (URL)</label>
                    <input type="url" name="url_fichier" class="form-control">
                </div>
                <div id="file_div" class="mb-3" style="display:none;">
                    <label class="form-label">Choisir un fichier</label>
                    <input type="file" name="fichier_local" class="form-control">
                </div>
                <div class="mb-3">
                    <label class="form-label">Description</label>
                    <textarea name="description" class="form-control" rows="3" required></textarea>
                </div>
                <button type="submit" class="btn btn-primary w-100">Publier ma ressource</button>
            </form>
        </div>
    </div>
</main>

<script>
function toggleInput() {
    var type = document.getElementById('type_source').value;
    document.getElementById('url_div').style.display = (type === 'lien') ? 'block' : 'none';
    document.getElementById('file_div').style.display = (type === 'upload') ? 'block' : 'none';
}
</script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>