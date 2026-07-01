<?php
// profil_ecole.php
session_start();
require_once 'config/db.php';

// Sécurité : Vérifier que l'utilisateur est bien connecté
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$id_ecole = $_SESSION['id_ecole'];

// Traitement du formulaire de mise à jour
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $sql = "UPDATE ecoles SET telephone = ?, adresse = ?, description_ecole = ? WHERE id = ?";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([
        $_POST['telephone'], 
        $_POST['adresse'], 
        $_POST['description_ecole'], 
        $id_ecole
    ]);
    $message = "Profil mis à jour avec succès !";
}

// Récupération des informations actuelles pour pré-remplir le formulaire
$stmt = $pdo->prepare("SELECT * FROM ecoles WHERE id = ?");
$stmt->execute([$id_ecole]);
$ecole = $stmt->fetch();

include 'inc/header.php';
?>

<div class="container mt-4">
    <div class="card shadow-sm border-0">
        <div class="card-header bg-primary text-white">
            <h4 class="mb-0">Mon Profil École</h4>
        </div>
        <div class="card-body">
            <?php if(isset($message)): ?>
                <div class='alert alert-success'><?= $message ?></div>
            <?php endif; ?>
            
            <form method="POST" class="mt-3">
                <div class="mb-3">
                    <label class="form-label">Numéro de téléphone (WhatsApp)</label>
                    <input type="text" name="telephone" class="form-control" value="<?= htmlspecialchars($ecole['telephone'] ?? '') ?>" placeholder="ex: +243XXXXXXXXXX" required>
                </div>
                <div class="mb-3">
                    <label class="form-label">Adresse physique</label>
                    <input type="text" name="adresse" class="form-control" value="<?= htmlspecialchars($ecole['adresse'] ?? '') ?>" required>
                </div>
                <div class="mb-3">
                    <label class="form-label">Présentation de votre institution</label>
                    <textarea name="description_ecole" class="form-control" rows="4"><?= htmlspecialchars($ecole['description_ecole'] ?? '') ?></textarea>
                </div>
                <div class="d-flex gap-2">
                    <button type="submit" class="btn btn-primary">Enregistrer les modifications</button>
                    <a href="index.php" class="btn btn-secondary">Retour au tableau de bord</a>
                </div>
            </form>
        </div>
    </div>
</div>

<?php include 'inc/footer.php'; ?>