<?php
session_start();
require_once 'config/db.php';
if (!isset($_SESSION['ecole_id'])) exit();

// On compte les messages (idéalement, ajoute une colonne 'lu' (0/1) dans ta table messages)
$stmt = $pdo->prepare("SELECT COUNT(*) FROM messages WHERE ecole_id = ? AND lu = 0");
$stmt->execute([$_SESSION['ecole_id']]);
echo json_encode(['count' => $stmt->fetchColumn()]);
?>