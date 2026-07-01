<?php
// 1. Inclusion des fichiers depuis le dossier 'inc'
require_once 'config/db.php'; 
include 'inc/header.php'; // Chemins corrigés
?>

<div class="container mt-5">
    <h2 class="mb-4">Bibliothèque de Ressources</h2>

    <div class="row">
        <?php
        // 2. Récupération des ressources
        $stmt = $pdo->query("SELECT * FROM ressources ORDER BY id DESC");
        $ressources = $stmt->fetchAll();

        foreach ($ressources as $r): ?>
            <div class="col-md-4 mb-4">
                <div class="card h-100 shadow-sm">
                    <div class="card-body">
                        <h5 class="card-title"><?= htmlspecialchars($r['titre']) ?></h5>
                        <span class="badge bg-secondary mb-2"><?= htmlspecialchars($r['type']) ?></li>
                        <p class="card-text"><?= htmlspecialchars($r['description']) ?></p>
                    </div>
                    <div class="card-footer bg-transparent border-top-0">
                        <?php 
                        // 3. Logique du bouton dynamique
                        if (isset($r['origine_contenu']) && strtolower($r['origine_contenu']) === 'upload'): ?>
                            <a href="download.php?id=<?= $r['id'] ?>" class="btn btn-success w-100" target="_blank">
                                <i class="fas fa-download"></i> Télécharger (<?= (int)$r['telechargements'] ?>)
                            </a>
                        <?php else: ?>
                            <a href="<?= htmlspecialchars($r['url_fichier']) ?>" class="btn btn-primary w-100" target="_blank">
                                <i class="fas fa-play"></i> Ouvrir la ressource
                            </a>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
</div>

<?php 
// 4. Inclusion du footer depuis le dossier 'inc'
include 'inc/footer.php'; 
?>