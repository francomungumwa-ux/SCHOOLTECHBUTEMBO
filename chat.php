<?php
session_start();
require_once 'config/db.php';
include 'inc/header.php';

$ecole_cible = isset($_GET['ecole_id']) ? (int)$_GET['ecole_id'] : 0;

// Récupération du nom de l'école
$nom_ecole = "Institution"; 
if ($ecole_cible > 0) {
    $stmt = $pdo->prepare("SELECT nom_ecole FROM ecoles WHERE id = ?");
    $stmt->execute([$ecole_cible]);
    $result = $stmt->fetch();
    if ($result) {
        $nom_ecole = $result['nom_ecole'];
    }
}
?>

<style>
    /* Design moderne des bulles de chat */
    #chat-box { display: flex; flex-direction: column; gap: 10px; }
    .bubble { max-width: 75%; padding: 10px 15px; border-radius: 15px; font-size: 14px; position: relative; }
    .bubble-me { background-color: #007bff; color: white; align-self: flex-end; border-bottom-right-radius: 2px; }
    .bubble-institution { background-color: #e9ecef; color: #333; align-self: flex-start; border-bottom-left-radius: 2px; }
    .sender-name { font-size: 11px; font-weight: bold; display: block; margin-bottom: 2px; }
    .msg-date { font-size: 10px; display: block; text-align: right; margin-top: 4px; opacity: 0.7; }
</style>

<div class="container mt-4">
    <div class="card shadow">
        <div class="card-header bg-primary text-white">
            Chat avec : <?php echo htmlspecialchars($nom_ecole); ?>
        </div>
        
        <div id="chat-box" style="height: 400px; overflow-y: scroll; padding: 15px; background-color: #f8f9fa;">
            Chargement...
        </div>

        <div class="card-footer">
            <form id="chat-form">
                <input type="hidden" id="ecole_id" value="<?php echo $ecole_cible; ?>">
                
                <?php if (!isset($_SESSION['user_name']) && !isset($_SESSION['ecole_id'])): ?>
                    <div class="mb-2">
                        <input type="text" id="nom_visiteur" class="form-control" placeholder="Votre nom" required>
                    </div>
                <?php elseif (isset($_SESSION['ecole_id'])): ?>
                    <input type="hidden" id="nom_visiteur" value="institution">
                <?php endif; ?>

                <div class="input-group">
                    <input type="text" id="msg-input" class="form-control" placeholder="Votre message..." required autocomplete="off">
                    <button type="submit" class="btn btn-success">Envoyer</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
const chatBox = document.getElementById('chat-box');
const ecoleId = document.getElementById('ecole_id') ? document.getElementById('ecole_id').value : 0;
const nomInput = document.getElementById('nom_visiteur');

// Charger le nom du visiteur depuis la mémoire du navigateur
if (nomInput) {
    const savedName = localStorage.getItem('visiteur_nom');
    if (savedName) nomInput.value = savedName;
}

function loadMessages() {
    if(ecoleId == 0) return;
    fetch('get_messages.php?ecole_id=' + ecoleId)
        .then(response => response.text())
        .then(data => { 
            chatBox.innerHTML = data; 
            chatBox.scrollTop = chatBox.scrollHeight;
        });
}

setInterval(loadMessages, 2000);
loadMessages();

document.getElementById('chat-form').onsubmit = function(e) {
    e.preventDefault();
    let msgInput = document.getElementById('msg-input');
    let message = msgInput.value;
    let nomVisiteur = nomInput ? nomInput.value : 'institution';

    if (message.trim() === "") return;

    if (nomInput) localStorage.setItem('visiteur_nom', nomVisiteur);

    let bodyData = 'ecole_id=' + ecoleId + '&message=' + encodeURIComponent(message) + '&nom_visiteur=' + encodeURIComponent(nomVisiteur);

    fetch('send_message.php', {
        method: 'POST',
        headers: {'Content-Type': 'application/x-www-form-urlencoded'},
        body: bodyData
    }).then(() => {
        msgInput.value = '';
        setTimeout(loadMessages, 300);
    });
};
</script>

<?php include 'inc/footer.php'; ?>