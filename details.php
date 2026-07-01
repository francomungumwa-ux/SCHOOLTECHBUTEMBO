<?php
require_once 'config/db.php';
include 'inc/header.php';
$id = $_GET['id'] ?? 0;
$labo = $pdo->prepare("SELECT * FROM laboratoires WHERE id = ?");
$labo->execute([$id]);
$item = $labo->fetch();
?>
<div class="container py-5">
    <h1><?= htmlspecialchars($item['nom_labo']) ?></h1>
    <img src="uploads/<?= htmlspecialchars($item['image_url']) ?>" class="img-fluid">
    <p>Capacité : <?= $item['capacite'] ?></p>
    <p>Matériel : <?= htmlspecialchars($item['materiels_additionnels']) ?></p>
    <a href="index.php" class="btn btn-secondary">Retour</a>
</div>
<?php include 'inc/footer.php'; ?>