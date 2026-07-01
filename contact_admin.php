<?php
require_once 'config/db.php';
include 'inc/header.php';

$message_statut = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $stmt = $pdo->prepare("INSERT INTO support_messages (nom_expediteur, email_expediteur, message) VALUES (?, ?, ?)");
    if ($stmt->execute([$_POST['nom'], $_POST['email'], $_POST['message']])) {
        $message_statut = "<div class='alert alert-success'>Votre message a bien été envoyé à l'administrateur.</div>";
    }
}
?>

<div class="container mt-4 col-md-6">
    <h3>Contacter l'Administration</h3>
    <?php echo $message_statut; ?>
    <form method="POST">
        <div class="mb-3">
            <label>Votre Nom</label>
            <input type="text" name="nom" class="form-control" required>
        </div>
        <div class="mb-3">
            <label>Votre Email</label>
            <input type="email" name="email" class="form-control" required>
        </div>
        <div class="mb-3">
            <label>Message</label>
            <textarea name="message" class="form-control" rows="5" required></textarea>
        </div>
        <button type="submit" class="btn btn-primary">Envoyer</button>
    </form>
</div>

<?php include 'inc/footer.php'; ?>