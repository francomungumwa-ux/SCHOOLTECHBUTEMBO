<?php
session_start();
require_once 'config/db.php';
include 'inc/header.php';

// Vérification : l'école doit être connectée
if (!isset($_SESSION['ecole_id'])) {
    die("Accès non autorisé.");
}

$ecole_id = $_SESSION['ecole_id'];

// On récupère tous les messages envoyés à cette école, regroupés par auteur
$stmt = $pdo->prepare("SELECT * FROM messages WHERE ecole_id = ? ORDER BY date_envoi DESC");
$stmt->execute([$ecole_id]);
$messages = $stmt->fetchAll();
?>

<div class="container mt-4">
    <h2>Boîte de réception des messages</h2>
    <table class="table table-hover mt-3">
        <thead class="table-dark">
            <tr>
                <th>Expéditeur</th>
                <th>Message</th>
                <th>Date</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($messages as $msg): ?>
            <tr>
                <td><strong><?= htmlspecialchars($msg['auteur']) ?></strong></td>
                <td><?= htmlspecialchars($msg['message']) ?></td>
                <td><?= $msg['date_envoi'] ?></td>
                <td>
                    <a href="chat.php?ecole_id=<?= $ecole_id ?>" class="btn btn-sm btn-primary">Répondre</a>
                </td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>
<?php include 'inc/footer.php'; ?>