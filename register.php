<?php
// register.php
require_once 'config/db.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nom = $_POST['nom_ecole'];
    $email = $_POST['email'];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
    $telephone = $_POST['telephone'];
    $adresse = $_POST['adresse'];
    $description = $_POST['description_ecole'];
    $statut = 'en_attente'; // Par défaut, en attente de validation admin

    $sql = "INSERT INTO ecoles (nom_ecole, email, password, telephone, adresse, description_ecole, statut) VALUES (?, ?, ?, ?, ?, ?, ?)";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([$nom, $email, $password, $telephone, $adresse, $description, $statut]);

    header("Location: login.php?msg=compte_cree");
    exit();
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <title>Inscription École</title>
</head>
<body class="bg-light">
<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card shadow">
                <div class="card-body">
                    <h3 class="card-title text-center mb-4">Inscription de votre École</h3>
                    <form method="POST">
                        <div class="mb-3">
                            <label>Nom de l'école</label>
                            <input type="text" name="nom_ecole" class="form-control" required>
                        </div>
                        <div class="mb-3">
                            <label>Email</label>
                            <input type="email" name="email" class="form-control" required>
                        </div>
                        <div class="mb-3">
                            <label>Mot de passe</label>
                            <input type="password" name="password" class="form-control" required>
                        </div>
                        <div class="mb-3">
                            <label>Téléphone (WhatsApp)</label>
                            <input type="text" name="telephone" class="form-control" placeholder="+243..." required>
                        </div>
                        <div class="mb-3">
                            <label>Adresse</label>
                            <input type="text" name="adresse" class="form-control" required>
                        </div>
                        <div class="mb-3">
                            <label>Présentation courte</label>
                            <textarea name="description_ecole" class="form-control" rows="3"></textarea>
                        </div>
                        <button type="submit" class="btn btn-primary w-100">S'inscrire</button>
                    </form>
                    <p class="mt-3 text-center"><a href="login.php">Déjà inscrit ? Connectez-vous</a></p>
                </div>
            </div>
        </div>
    </div>
</div>
</body>
</html>