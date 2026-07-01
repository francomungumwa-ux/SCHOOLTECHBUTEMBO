<?php
session_start();
require_once 'config/db.php';

// 1. Sécurité
if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    header("Location: login.php");
    exit();
}

// 2. Traitement : Si une action de "marquage comme lu" est envoyée
if (isset($_GET['marquer_lu'])) {
    $id = (int)$_GET['marquer_lu'];
    $stmt = $pdo->prepare("UPDATE support_messages SET lu = 1 WHERE id = ?");
    $stmt->execute([$id]);
    
    // On redirige pour rafraîchir le compteur immédiatement
    header("Location: dashboard.php");
    exit();
}

// 3. Récupération des données pour le dashboard
$stmt = $pdo->query("SELECT COUNT(*) FROM ecoles WHERE statut = 'en_attente'");
$nb_en_attente = $stmt->fetchColumn();

// REQUÊTE CORRIGÉE : On compte seulement les messages où lu est égal à 0
$stmt_msg = $pdo->query("SELECT COUNT(*) FROM support_messages WHERE lu = 0");
$nb_messages = $stmt_msg->fetchColumn();
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Dashboard Admin - School Tech Butembo</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    
    <link rel="stylesheet" href="style.css"> 
</head>
<body class="bg-light">

<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
    <div class="container">
        <a class="navbar-brand" href="#">Panel Administrateur</a>
        <div class="navbar-nav ms-auto">
            <a class="nav-link text-danger" href="logout.php"><i class="fas fa-sign-out-alt"></i> Déconnexion</a>
        </div>
    </div>
</nav>

<div class="container mt-5">
    <div class="card p-4 shadow-sm border-0">
        <h1>Bienvenue, Administrateur</h1>
        <p class="lead">Gestion de <strong>School Tech Butembo</strong>.</p>
        
        <div class="row mt-4">
            <div class="col-md-6">
                <div class="alert alert-info">
                    <i class="fas fa-school"></i> Ecoles en attente : <strong><?= $nb_en_attente ?></strong>
                    <br><br>
                    <a href="admin_valider.php" class="btn btn-sm btn-primary">Valider les écoles</a>
                </div>
            </div>
            <div class="col-md-6">
                <div class="alert alert-warning">
                    <i class="fas fa-envelope"></i> Nouveaux messages support : <strong><?= $nb_messages ?></strong>
                    <br><br>
                    <a href="admin_support.php" class="btn btn-sm btn-warning">Voir les messages</a>
                </div>
            </div>
        </div>

        <div class="mt-3">
            <a href="index.php" class="btn btn-outline-secondary">Retour à l'accueil</a>
        </div>
    </div>
</div>
</body>
</html>