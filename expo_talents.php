<?php
// On démarre la session pour gérer l'affichage conditionnel (bouton poster)
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
require_once 'config/db.php';
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Expo Talents - School Tech Butembo</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <link rel="stylesheet" href="style.css">
</head>
<body class="bg-light">

<?php include 'navbar.php'; ?> 

<main class="container mt-5">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2><i class="fas fa-star text-warning"></i> Expo Talents</h2>
        
        <?php if(isset($_SESSION['role']) && $_SESSION['role'] === 'admin'): ?>
            <a href="ajouter_talent.php" class="btn btn-primary shadow-sm"><i class="fas fa-plus"></i> Ajouter un contenu</a>
        <?php endif; ?>
    </div>

    <div class="row">
        <?php
        $talents = $pdo->query("SELECT * FROM talents ORDER BY date_publication DESC")->fetchAll();
        
        if (empty($talents)): ?>
            <div class="col-12 text-center mt-5">
                <p class="text-muted">Aucun talent pour le moment. Revenez bientôt !</p>
            </div>
        <?php else: 
            foreach ($talents as $talent): ?>
            <div class="col-md-4 mb-4">
                <div class="card h-100 border-0 shadow-sm">
                    <div class="card-body">
                        <h5 class="card-title"><?= htmlspecialchars($talent['titre']) ?></h5>
                        <p class="card-text text-muted small"><?= htmlspecialchars($talent['description']) ?></p>
                        
                        <?php if ($talent['type_contenu'] == 'video'): ?>
                            <div class="ratio ratio-16x9 mb-3">
                                <iframe src="<?= htmlspecialchars($talent['url_contenu']) ?>" allowfullscreen></iframe>
                            </div>
                        <?php else: ?>
                            <a href="<?= htmlspecialchars($talent['url_contenu']) ?>" target="_blank" class="btn btn-success w-100 mb-3">
                                <i class="fas fa-gamepad"></i> Jouer / Voir
                            </a>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
            <?php endforeach; 
        endif; ?>
    </div>
</main>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>