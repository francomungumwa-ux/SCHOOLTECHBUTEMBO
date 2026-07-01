<nav class="navbar navbar-expand-lg navbar-dark bg-primary shadow-sm mb-4">
  <div class="container">
    <a class="navbar-brand fw-bold" href="index.php">School Tech Butembo</a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarNav">
      <div class="navbar-nav ms-auto align-items-center">
        <a class="nav-link" href="index.php">Accueil</a>
        <a class="nav-link" href="ressources.php">Ressources</a>
        <a class="nav-link" href="a_propos.php">Ecoles</a>
        <a class="nav-link" href="expo_talents.php">Expo Talents</a>
        <a class="nav-link" href="contact_admin.php">Support</a>
        <?php if(isset($_SESSION['user_id'])): ?>
          <a class="nav-link fw-bold text-warning" href="dashboard.php">Tableau de Bord</a>
          <a class="nav-link" href="logout.php">Déconnexion</a>
        <?php else: ?>
          <a class="nav-link btn btn-outline-light btn-sm px-3 mx-1" href="login.php">Connexion</a>
        <?php endif; ?>
      </div>
    </div>
  </div>
</nav>