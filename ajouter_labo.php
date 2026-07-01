<?php
// ajouter_labo.php
session_start();
require_once 'config/db.php';

// Sécurité
if (!isset($_SESSION['user_id'])) { 
    header("Location: login.php"); 
    exit(); 
}

$message = "";
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Insertion dans la base de données
    $stmt = $pdo->prepare("INSERT INTO laboratoires (nom_labo, description, equipements, capacite, auteur_id) VALUES (?, ?, ?, ?, ?)");
    $stmt->execute([
        $_POST['nom_labo'], 
        $_POST['description'], 
        $_POST['equipements'], 
        $_POST['capacite'], 
        $_SESSION['user_id']
    ]);
    $message = "<div class='alert alert-success'>Laboratoire ajouté avec succès !</div>";
}

include 'inc/header.php';
?>

<div class="container mt-5">
    <div class="col-md-8 mx-auto">
        <h2 class="mb-4 text-primary">Ajouter un Laboratoire</h2>
        <?= $message ?>
        
        <form method="POST" class="card p-4 shadow-sm border-0">
            <div class="mb-3">
                <label class="form-label">Nom du Laboratoire</label>
                <input type="text" name="nom_labo" class="form-control" required placeholder="Ex: Labo Informatique A">
            </div>
            
            <div class="mb-3">
                <label class="form-label">Description</label>
                <textarea name="description" class="form-control" rows="3" required></textarea>
            </div>
            
            <div class="mb-3">
                <label class="form-label">Équipements (ex: Ordinateurs, Projecteurs...)</label>
                <input type="text" name="equipements" class="form-control" required>
            </div>
            
            <div class="mb-3">
                <label class="form-label">Capacité (nombre de places)</label>
                <input type="number" name="capacite" class="form-control" required>
            </div>
            
            <button type="submit" class="btn btn-primary w-100">Enregistrer le Laboratoire</button>
            <a href="dashboard.php" class="btn btn-link w-100 mt-2">Retour au tableau de bord</a>
        </form>
    </div>
</div>

<?php include 'inc/footer.php'; ?>