<?php
session_start();
require_once 'config/db.php';

$message = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = trim($_POST['email']);
    $password = $_POST['password'];

    // 1. Chercher dans 'utilisateurs' (Admin)
    $stmt = $pdo->prepare("SELECT * FROM utilisateurs WHERE email = ?");
    $stmt->execute([$email]);
    $user = $stmt->fetch();
    $source = 'admin';

    // 2. Si pas trouvé, chercher dans 'ecoles'
    if (!$user) {
        $stmt = $pdo->prepare("SELECT * FROM ecoles WHERE email = ?");
        $stmt->execute([$email]);
        $user = $stmt->fetch();
        $source = 'ecole';
    }

    if ($user) {
        // Détection de la colonne mot de passe
        $col_pwd = array_key_exists('password', $user) ? 'password' : 'mot_de_passe';
        $pass_bdd = $user[$col_pwd];

        // Vérification mot de passe
        if (password_verify($password, $pass_bdd) || $password === $pass_bdd) {
            
            if ($source == 'ecole') {
                $statut = isset($user['statut']) ? trim($user['statut']) : '';
                
                if ($statut !== 'valide') {
                    $message = "Votre compte est en attente de validation par l'administrateur.";
                } else {
                    // --- ACCÈS ÉCOLE ---
                    $_SESSION['user_id'] = $user['id'];
                    $_SESSION['ecole_id'] = $user['id']; // Indispensable pour le menu "Messages"
                    $_SESSION['user_name'] = $user['nom_ecole'];
                    $_SESSION['role'] = 'ecole';
                    
                    header("Location: dashboard.php");
                    exit();
                }
            } else {
                // --- ACCÈS ADMIN ---
                $_SESSION['user_id'] = $user['id'];
                $_SESSION['role'] = $user['role'];
                
                header("Location: dashboard_admin.php");
                exit();
            }
        } else {
            $message = "Mot de passe incorrect.";
        }
    } else {
        $message = "Email inconnu.";
    }
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Connexion - School Tech Butembo</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
    <div class="container mt-5">
        <div class="card col-md-4 mx-auto p-4 shadow-sm border-0">
            <h3 class="text-center mb-4">Connexion</h3>
            <?php if($message): ?>
                <div class='alert alert-danger'><?php echo htmlspecialchars($message); ?></div>
            <?php endif; ?>
            <form method="POST">
                <div class="mb-3">
                    <label class="form-label">Email</label>
                    <input type="email" name="email" class="form-control" required>
                </div>
                <div class="mb-3">
                    <label class="form-label">Mot de passe</label>
                    <input type="password" name="password" class="form-control" required>
                </div>
                <button type="submit" class="btn btn-primary w-100">Se connecter</button>
            </form>
            <div class="mt-3 text-center">
                <p>Pas encore inscrit ? <a href="register.php">Créer un compte</a></p>
            </div>
        </div>
    </div>
</body>
</html>