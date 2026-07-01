<?php
// dashboard.php
session_start();
require_once 'config/db.php';
if (!isset($_SESSION['user_id'])) { header("Location: login.php"); exit(); }

include 'inc/header.php';
?>

<div class="container mt-5">
    <h1 class="mb-4">Espace Institutionnel</h1>
    <div class="row g-4">
        
        <div class="col-md-4">
            <div class="card h-100 border-primary shadow-sm">
                <div class="card-body">
                    <h5 class="card-title text-primary">Mes Laboratoires</h5>
                    <p class="card-text">Gérez vos espaces techniques partagés avec les étudiants.</p>
                    <a href="ajouter_labo.php" class="btn btn-outline-primary w-100">Ajouter un Labo</a>
                </div>
            </div>
        </div>
        
        <div class="col-md-4">
            <div class="card h-100 border-success shadow-sm">
                <div class="card-body">
                    <h5 class="card-title text-success">Mes Ressources</h5>
                    <p class="card-text">Partagez vos cours, vidéos ou documents pédagogiques.</p>
                    <a href="ajouter_ressource.php" class="btn btn-outline-success w-100">Ajouter une Ressource</a>
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card h-100 border-warning shadow-sm">
                <div class="card-body">
                    <h5 class="card-title text-warning">Gérer mes contenus</h5>
                    <p class="card-text">Visualisez, modifiez ou supprimez vos publications existantes.</p>
                    <a href="mes_contenus.php" class="btn btn-outline-warning w-100">Voir mes publications</a>
                </div>
            </div>
        </div>
        
    </div>
</div>

<?php include 'inc/footer.php'; ?>