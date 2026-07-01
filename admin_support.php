<?php
session_start();
require_once 'config/db.php';

// 1. Sécurité admin
if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    header("Location: login.php");
    exit();
}

// 2. Traitement : Marquer comme lu
if (isset($_GET['action']) && $_GET['action'] === 'marquer_lu' && isset($_GET['id'])) {
    $id = (int)$_GET['id'];
    $stmt = $pdo->prepare("UPDATE support_messages SET lu = 1 WHERE id = ?");
    $stmt->execute([$id]);
    
    $_SESSION['flash'] = "Le message a été marqué comme lu avec succès !";
    header("Location: admin_support.php");
    exit();
}

// 3. Traitement de la recherche
$recherche = isset($_GET['q']) ? trim($_GET['q']) : '';
$sql = "SELECT * FROM support_messages";

if (!empty($recherche)) {
    $sql .= " WHERE nom_expediteur LIKE :q OR email_expediteur LIKE :q";
}

$sql .= " ORDER BY date_envoi DESC";

$stmt = $pdo->prepare($sql);
if (!empty($recherche)) {
    $stmt->execute(['q' => "%$recherche%"]);
} else {
    $stmt->execute();
}
$messages = $stmt->fetchAll();
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Support Admin - School Tech Butembo</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <link rel="stylesheet" href="style.css">
</head>
<body class="bg-light">

<div class="container mt-4">
    <?php if (isset($_SESSION['flash'])): ?>
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <i class="fas fa-check-circle"></i> <?= $_SESSION['flash']; ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
        <?php unset($_SESSION['flash']); ?>
    <?php endif; ?>

    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2><i class="fas fa-headset"></i> Messages de Support</h2>
        <a href="dashboard_admin.php" class="btn btn-secondary"><i class="fas fa-arrow-left"></i> Retour</a>
    </div>

    <div class="card mb-4 shadow-sm border-0">
        <div class="card-body">
            <form action="admin_support.php" method="GET" class="d-flex">
                <input type="text" name="q" class="form-control me-2" placeholder="Rechercher par nom ou email..." value="<?= htmlspecialchars($recherche) ?>">
                <button type="submit" class="btn btn-primary"><i class="fas fa-search"></i></button>
                <?php if (!empty($recherche)): ?>
                    <a href="admin_support.php" class="btn btn-outline-danger ms-2">Annuler</a>
                <?php endif; ?>
            </form>
        </div>
    </div>
    
    <div class="table-responsive">
        <table class="table table-hover align-middle">
            <thead class="table-dark">
                <tr>
                    <th>Date</th>
                    <th>Nom</th>
                    <th>Email</th>
                    <th>Message</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($messages as $m): ?>
                    <tr class="<?= ($m['lu'] == 0) ? 'table-warning' : ''; ?>">
                        <td style="white-space: nowrap;"><?= date("d/m/Y H:i", strtotime($m['date_envoi'])) ?></td>
                        <td><?= htmlspecialchars($m['nom_expediteur']) ?></td>
                        <td>
                            <span id="email-<?= $m['id'] ?>"><?= htmlspecialchars($m['email_expediteur']) ?></span>
                            <button class="btn btn-link btn-sm text-dark" onclick="copierEmail('email-<?= $m['id'] ?>')" title="Copier email">
                                <i class="fas fa-copy"></i>
                            </button>
                        </td>
                        <td><?= nl2br(htmlspecialchars($m['message'])) ?></td>
                        <td>
                            <div class="btn-group-vertical">
                                <a href="mailto:<?= $m['email_expediteur'] ?>?subject=Re: Support School Tech Butembo" 
                                   class="btn btn-sm btn-primary mb-1">
                                   <i class="fas fa-reply"></i> Répondre
                                </a>
                                <?php if ($m['lu'] == 0): ?>
                                    <a href="admin_support.php?action=marquer_lu&id=<?= $m['id'] ?>" class="btn btn-sm btn-success">
                                        <i class="fas fa-check"></i> Lu
                                    </a>
                                <?php else: ?>
                                    <span class="badge bg-secondary"><i class="fas fa-check-double"></i> Lu</span>
                                <?php endif; ?>
                            </div>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script>
function copierEmail(id) {
    const email = document.getElementById(id).innerText;
    navigator.clipboard.writeText(email).then(() => {
        alert("Email copié dans le presse-papier !");
    });
}
</script>
</body>
</html>