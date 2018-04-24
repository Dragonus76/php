<?php

session_start();

echo '<pre>';
print_r($_SESSION);
echo '</pre>';

// Ce fichier session2.php n'a rien à voir avec session1.php (pas d'inclusion) et pourtant on a accès à toutes les informations créées dans le fichier 1.

// Ceci est rendu possible par l'utilisation de session_start() et de la superglobale SESSION. session_start ouvre le fichier de session et $_SESSION permet d'accéder aux infos.

// Ce fichier pourrait être n'importe où sur le serveur que cela fonctionnerait.

?>