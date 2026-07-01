<?php
session_start();
require_once 'config/db.php';

// 1. Vérification de la connexion
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

// 2. Récupération de l'ID du labo
$id = isset($_GET['id']) ? $_GET['id'] : 0;
$stmt = $pdo->prepare("SELECT * FROM laboratoires WHERE id = ?");
$stmt->execute([$id]);
$labo = $stmt->fetch();

if (!$labo) {
    die("Laboratoire introuvable.");
}

// 3. Traitement du formulaire
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nom = $_POST['nom_labo'];
    $cap = $_POST['capacite'];
    $desc = $_POST['description'];
    $horaire = $_POST['horaire_service'];
    $equip = $_POST['equipements']; // Nouveau champ

    // Si une nouvelle image est sélectionnée
    if (isset($_FILES['image_labo']) && $_FILES['image_labo']['error'] == 0) {
        $dossier = 'assets/';
        $nom_fichier = time() . '_' . basename($_FILES['image_labo']['name']);
        $nouveau_path = $dossier . $nom_fichier;
        
        // Supprimer l'ancienne image si elle existe
        if (!empty($labo['image_url']) && file_exists($labo['image_url'])) {
            unlink($labo['image_url']);
        }
        
        move_uploaded_file($_FILES['image_labo']['tmp_name'], $nouveau_path);
        
        $sql = "UPDATE laboratoires SET nom_labo=?, capacite=?, description=?, horaire_service=?, equipements=?, image_url=? WHERE id=?";
        $pdo->prepare($sql)->execute([$nom, $cap, $desc, $horaire, $equip, $nouveau_path, $id]);
    } else {
        // Juste mise à jour du texte et équipements
        $sql = "UPDATE laboratoires SET nom_labo=?, capacite=?, description=?, horaire_service=?, equipements=? WHERE id=?";
        $pdo->prepare($sql)->execute([$nom, $cap, $desc, $horaire, $equip, $id]);
    }

    header("Location: index.php");
    exit();
}

include 'inc/header.php';
?>

<div class="container mt-4">
    <h2>Modifier : <?= htmlspecialchars($labo['nom_labo']) ?></h2>
    <form method="POST" enctype="multipart/form-data" class="mt-4">
        <div class="mb-3">
            <label>Nom du Laboratoire</label>
            <input type="text" name="nom_labo" class="form-control" value="<?= htmlspecialchars($labo['nom_labo']) ?>" required>
        </div>
        <div class="mb-3">
            <label>Capacité</label>
            <input type="number" name="capacite" class="form-control" value="<?= $labo['capacite'] ?>" required>
        </div>
        <div class="mb-3">
            <label>Description</label>
            <textarea name="description" class="form-control" rows="3"><?= htmlspecialchars($labo['description']) ?></textarea>
        </div>
        <div class="mb-3">
            <label>Horaires de service</label>
            <input type="text" name="horaire_service" class="form-control" value="<?= htmlspecialchars($labo['horaire_service']) ?>">
        </div>
        <div class="mb-3">
            <label>Équipements</label>
            <textarea name="equipements" class="form-control" rows="2"><?= htmlspecialchars($labo['equipements']) ?></textarea>
        </div>
        <div class="mb-3">
            <label>Changer l'image</label>
            <input type="file" name="image_labo" class="form-control" accept="image/*">
            <?php if ($labo['image_url']): ?>
                <p class="mt-2">Image actuelle : <img src="<?= $labo['image_url'] ?>" width="100"></p>
            <?php endif; ?>
        </div>
        <button type="submit" class="btn btn-warning">Enregistrer les modifications</button>
        <a href="index.php" class="btn btn-secondary">Annuler</a>
    </form>
</div>

<?php include 'inc/footer.php'; ?>