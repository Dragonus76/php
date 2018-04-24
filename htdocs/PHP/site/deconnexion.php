<?php
require_once('inc/init.inc.php');

unset($_SESSION['membre']); // On supprime la partie membre de la sassion (et seulement la partie membre!) car on vaudrait garder les infos liées au panier.

header('location:index.php');

?>