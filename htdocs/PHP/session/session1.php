<?php

session_start(); //Cette fonction permet de créer un fichier de session. Si le fichier existe déjà alors ça va l'ouvrir.

$_SESSION['pseudo'] = 'Julie';
$_SESSION['password'] = '123456';
// La SUPERGLOBALE $_SESSION représente le fichier de session

echo '<pre>';
print_r($_SESSION);
echo '</pre>';

unset($_SESSION['password']); // unset() fonctionne avec tous les ARRAY

echo '<pre>';
print_r($_SESSION);
echo '</pre>';

session_destroy(); // supprime tout le fichier. Il n'est plus dans le dossier tmp! Attention il est exécuté à la fin du script quelque soit sa place dans l'écriture.
// Pour déconnecter un utilisateur on va d'abord unset les infos dans $_SESSION puis éventuellement supprimer le fichier de session.

echo '<pre>';
print_r($_SESSION);
echo '</pre>';


?>