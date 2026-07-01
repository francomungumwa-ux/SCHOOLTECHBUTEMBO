<?php
// ajouter_ecole.php
session_start();
require_once 'config/db.php';

// Protection : seul l'admin peut ajouter des écoles
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    die("Accès refusé : vous devez être administrateur.");
}

$message = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nom = $_POST['nom_ecole'];
    $adresse = $_POST['adresse'];
    $telephone = $_POST['telephone'];

    $stmt = $pdo->prepare("INSERT INTO ecoles (nom_ecole, adresse, telephone) VALUES (?, ?, ?)");
    if ($stmt->execute([$nom, $adresse, $telephone])) {
        $message = "École ajoutée avec succès !";
    } else {
        $message = "Erreur lors de l'ajout.";
    }
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Ajouter une école</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
    <div class="container mt-5">
        <div class="card p-4 shadow">
            <h2>Ajouter une nouvelle école</h2>
            <?php if($message) echo "<div class='alert alert-info'>$message</div>"; ?>
            <form method="POST">
                <div class="mb-3">
                    <label>Nom de l'école</label>
                    <input type="text" name="nom_ecole" class="form-control" required>
                </div>
                <div class="mb-3">
                    <label>Adresse</label>
                    <input type="text" name="adresse" class="form-control">
                </div>
                <div class="mb-3">
                    <label>Téléphone</label>
                    <input type="text" name="telephone" class="form-control">
                </div>
                <button type="submit" class="btn btn-primary">Enregistrer l'école</button>
                <a href="index.php" class="btn btn-secondary">Retour au tableau de bord</a>
            </form>
        </div>
    </div>
</body>
</html>