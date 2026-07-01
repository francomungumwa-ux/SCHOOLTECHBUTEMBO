<?php
session_start();
require_once 'config/db.php';

// 1. Sécurité : Vérification admin
if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    header('Location: login.php');
    exit();
}

// 2. Action de validation : Change le statut de l'école en 'valide'
if (isset($_GET['valider'])) {
    $stmt = $pdo->prepare("UPDATE ecoles SET statut = 'valide' WHERE id = ?");
    $stmt->execute([$_GET['valider']]);
    // Redirection pour rafraîchir la liste après validation
    header("Location: admin_valider.php");
    exit();
}

// 3. Récupération des écoles en attente
$query = "SELECT id, nom_ecole, email, telephone FROM ecoles WHERE statut = 'en_attente'";
$stmt = $pdo->query($query);
$ecoles = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Validation Écoles</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">

<div class="container mt-5">
    <div class="card shadow-sm p-4">
        <h2>Écoles en attente de validation</h2>
        <hr>
        
        <table class="table table-bordered table-striped mt-3">
            <thead class="table-dark">
                <tr>
                    <th>Nom École</th>
                    <th>Email</th>
                    <th>Téléphone</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <?php if ($ecoles && count($ecoles) > 0): ?>
                    <?php foreach ($ecoles as $e): ?>
                    <tr>
                        <td><?php echo isset($e['nom_ecole']) ? htmlspecialchars($e['nom_ecole']) : 'N/A'; ?></td>
                        <td><?php echo isset($e['email']) ? htmlspecialchars($e['email']) : 'N/A'; ?></td>
                        <td><?php echo isset($e['telephone']) ? htmlspecialchars($e['telephone']) : 'N/A'; ?></td>
                        <td>
                            <a href="admin_valider.php?valider=<?php echo $e['id']; ?>" class="btn btn-success btn-sm">Valider</a>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="4" class="text-center">Aucune école en attente pour le moment.</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
        
        <a href="dashboard_admin.php" class="btn btn-secondary mt-3">Retour au tableau de bord</a>
    </div>
</div>

</body>
</html>