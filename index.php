<?php
// index.php (Page publique)
require_once 'config/db.php';
include 'inc/header.php';

// Gestion de la recherche
$search = (isset($_GET['q'])) ? $_GET['q'] : '';
if ($search) {
    $stmt = $pdo->prepare("SELECT * FROM laboratoires WHERE nom_labo LIKE ? OR equipements LIKE ?");
    $stmt->execute(["%$search%", "%$search%"]);
} else {
    $stmt = $pdo->query("SELECT * FROM laboratoires");
}
$labos = $stmt->fetchAll();
?>

<div class="bg-light py-5">
    <div class="container">
        <h1 class="mb-2 text-center text-primary">Bienvenue sur School Tech Butembo</h1>
        <p class="lead text-center mb-5">Découvrez les laboratoires partagés par nos institutions partenaires.</p>

        <form method="GET" class="mb-5 row justify-content-center">
            <div class="col-md-6">
                <div class="input-group shadow-sm">
                    <input type="text" name="q" class="form-control" placeholder="Rechercher un labo ou équipement..." value="<?= htmlspecialchars($search) ?>">
                    <button class="btn btn-primary" type="submit">Rechercher</button>
                </div>
            </div>
        </form>

        <div class="row">
            <?php if (count($labos) > 0): ?>
                <?php foreach ($labos as $labo): ?>
                <?php 
                    $img = !empty($labo['image_url']) ? htmlspecialchars($labo['image_url']) : 'assets/default.png';
                ?>
                <div class="col-md-4 mb-4">
                    <div class="card h-100 shadow border-0 overflow-hidden">
                        <img src="<?= $img ?>" class="card-img-top" alt="Laboratoire" style="height: 200px; object-fit: cover;">
                        <div class="card-body">
                            <h5 class="card-title text-primary"><?= htmlspecialchars($labo['nom_labo']) ?></h5>
                            <p class="card-text text-muted"><?= htmlspecialchars($labo['description']) ?></p>
                            
                            <div class="p-3 bg-primary bg-opacity-10 rounded border-start border-primary border-4 mb-3">
                                <strong class="text-primary small">Équipements :</strong>
                                <p class="mb-0 small"><?= htmlspecialchars($labo['equipements']) ?></p>
                            </div>
                        </div>
                        <div class="card-footer bg-white border-0 pb-3">
                             <div class="d-flex justify-content-between align-items-center">
                                <span class="badge bg-secondary">Capacité : <?= htmlspecialchars($labo['capacite']) ?> postes</span>
                                <a href="details_labo.php?id=<?= $labo['id'] ?>" class="btn btn-sm btn-primary">Voir détails</a>
                             </div>
                        </div>
                    </div>
                </div>
                <?php endforeach; ?>
            <?php else: ?>
                <div class="col-12 text-center">
                    <p class="text-muted">Aucun laboratoire trouvé pour votre recherche.</p>
                </div>
            <?php endif; ?>
        </div>
    </div>
</div>

<?php include 'inc/footer.php'; ?>