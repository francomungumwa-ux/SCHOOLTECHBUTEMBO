<?php
// details_labo.php
require_once 'config/db.php';
include 'inc/header.php';

// Récupération de l'ID du labo
$id = isset($_GET['id']) ? $_GET['id'] : 0;

// Requête jointe pour avoir les infos du labo ET de l'école
$stmt = $pdo->prepare("SELECT l.*, e.nom_ecole, e.telephone, e.adresse 
                        FROM laboratoires l 
                        JOIN ecoles e ON l.ecole_id = e.id 
                        WHERE l.id = ?");
$stmt->execute([$id]);
$labo = $stmt->fetch();

if (!$labo) { echo "<div class='container mt-5'>Laboratoire introuvable.</div>"; exit(); }

// Préparation des variables avec vérification pour éviter les erreurs PHP 5.5
$image_url = isset($labo['image_url']) && !empty($labo['image_url']) ? $labo['image_url'] : 'assets/default.png';
?>

<div class="container mt-5">
    <div class="row">
        <div class="col-md-6">
            <img src="<?= htmlspecialchars($image_url) ?>" class="img-fluid rounded shadow" alt="Labo">
        </div>
        <div class="col-md-6">
            <h1><?= htmlspecialchars($labo['nom_labo']) ?></h1>
            <h4 class="text-primary"><?= htmlspecialchars($labo['nom_ecole']) ?></h4>
            <p class="mt-3"><?= htmlspecialchars($labo['description']) ?></p>
            
            <div class="card bg-light border-0 p-3 mt-4">
                <p><strong>Équipements :</strong> <?= htmlspecialchars($labo['equipements']) ?></p>
                <p><strong>Capacité :</strong> <?= htmlspecialchars($labo['capacite']) ?> postes</p>
                <p><strong>Localisation :</strong> <?= htmlspecialchars($labo['adresse']) ?></p>
            </div>

            <a href="https://wa.me/<?= preg_replace('/[^0-9]/', '', $labo['telephone']) ?>" 
               target="_blank" class="btn btn-success btn-lg mt-4">
               Contacter l'école sur WhatsApp
            </a>
        </div>
    </div>
</div>
<?php include 'inc/footer.php'; ?>