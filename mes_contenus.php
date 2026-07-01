<?php
session_start();
require_once 'config/db.php';
if (!isset($_SESSION['user_id'])) { header("Location: login.php"); exit(); }

// Suppression
if (isset($_GET['delete_labo'])) {
    $stmt = $pdo->prepare("DELETE FROM laboratoires WHERE id = ? AND auteur_id = ?");
    $stmt->execute([$_GET['delete_labo'], $_SESSION['user_id']]);
}

// Récupération des données
$labos = $pdo->prepare("SELECT * FROM laboratoires WHERE auteur_id = ?");
$labos->execute([$_SESSION['user_id']]);
$mes_labos = $labos->fetchAll();

include 'inc/header.php';
?>

<div class="container mt-5">
    <h2>Mes publications</h2>
    <table class="table mt-4">
        <thead>
            <tr>
                <th>Nom</th>
                <th>Type</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($mes_labos as $l): ?>
            <tr>
                <td><?= htmlspecialchars($l['nom_labo']) ?></td>
                <td>Laboratoire</td>
                <td>
                    <a href="mes_contenus.php?delete_labo=<?= $l['id'] ?>" class="btn btn-danger btn-sm" onclick="return confirm('Supprimer ?')">Supprimer</a>
                </td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>
<?php include 'inc/footer.php'; ?>