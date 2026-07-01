<?php
// a_propos.php
require_once 'config/db.php';
include 'inc/header.php';

$query = $pdo->query("SELECT * FROM ecoles");
$ecoles = $query->fetchAll();
?>

<div class="container mt-5">
    <div class="text-center mb-5">
        <h1 class="display-5 text-primary">Annuaire des Institutions</h1>
        <p class="lead">Découvrez les écoles partenaires de School Tech Butembo.</p>
    </div>

    <div class="row">
        <?php if (count($ecoles) > 0): ?>
            <?php foreach ($ecoles as $ecole): ?>
            <div class="col-md-4 mb-4">
                <div class="card h-100 shadow-sm border-0">
                    <div class="card-body">
                        <h5 class="card-title text-primary"><?= htmlspecialchars(isset($ecole['nom']) ? $ecole['nom'] : 'Institution Partenaire') ?></h5>
                        <small>📍 Située à Butembo</small><br>
                        <small>📧 Contact : <?= htmlspecialchars($ecole['email']) ?></small>
                        <br><br>
                        <!-- MODIFICATION ICI : On utilise un chemin relatif propre -->
                        <a href="chat.php?ecole_id=<?= (int)$ecole['id'] ?>" class="btn btn-primary btn-sm">Ouvrir le Chat</a>
                    </div>
                </div>
            </div>
            <?php endforeach; ?>
        <?php else: ?>
            <div class="col-12 text-center">
                <p>Aucune institution partenaire n'est encore enregistrée.</p>
            </div>
        <?php endif; ?>
    </div>
</div>

<?php include 'inc/footer.php'; ?>