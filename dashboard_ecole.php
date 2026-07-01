<?php
session_start();
require_once 'config/db.php';
include 'inc/header.php';

// Vérification de sécurité : Seule l'école doit accéder à cette page
if (!isset($_SESSION['ecole_id'])) {
    echo "<div class='container mt-5'><div class='alert alert-danger'>Accès refusé. Veuillez vous connecter en tant qu'institution.</div></div>";
    include 'inc/footer.php';
    exit();
}

$ecole_id = $_SESSION['ecole_id'];

// On récupère tous les messages reçus par cette école
$stmt = $pdo->prepare("SELECT * FROM messages WHERE ecole_id = ? ORDER BY date_envoi DESC");
$stmt->execute([$ecole_id]);
$messages = $stmt->fetchAll();
?>

<div class="container mt-4">
    <div class="card shadow">
        <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
            <h4 class="mb-0">Boîte de réception - Institution</h4>
            <a href="logout.php" class="btn btn-sm btn-outline-light">Déconnexion</a>
        </div>
        
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-hover align-middle">
                    <thead class="table-light">
                        <tr>
                            <th>Date</th>
                            <th>Expéditeur</th>
                            <th>Message</th>
                            <th class="text-center">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (count($messages) > 0): ?>
                            <?php foreach ($messages as $msg): ?>
                                <tr>
                                    <td><small class="text-muted"><?php echo date("d/m/Y H:i", strtotime($msg['date_envoi'])); ?></small></td>
                                    <td><strong><?php echo htmlspecialchars($msg['auteur'], ENT_QUOTES, 'UTF-8'); ?></strong></td>
                                    <td><?php echo htmlspecialchars($msg['message'], ENT_QUOTES, 'UTF-8'); ?></td>
                                    <td class="text-center">
                                        <a href="chat.php?ecole_id=<?php echo $ecole_id; ?>" class="btn btn-sm btn-info text-white">
                                            <i class="fas fa-reply"></i> Répondre
                                        </a>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <tr>
                                <td colspan="4" class="text-center text-muted">Aucun message pour le moment.</td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<?php include 'inc/footer.php'; ?>