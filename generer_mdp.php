<?php
$mdp = "admin123";
$hash = password_hash($mdp, PASSWORD_DEFAULT);
echo "Copie ce hachage et colle-le dans ta base de données : <br><strong>" . $hash . "</strong>";
?>