<?php
// Ce fichier init.inc.php sert à stocker toutes les fonctions php nécessaires au fonctionnement d'un site internet

// session :
session_start(); // ouvre (ou crée s'il n'existait pas) un fichier contenant les informations de session

// connexion : // connexion à la BDD
$pdo = new PDO('mysql:host=localhost;dbname=site', 'root', '', array(
	PDO::ATTR_ERRMODE => PDO::ERRMODE_WARNING,
	PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES utf8',
	PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
));

// variables : // création des variables vides
$msg = "";
$page = ""; // afficher dynamiquement le nom de chaque page dans les onglets
$meta_description = ""; // afficher dynamiquement la description de chaque page lors d'une recherche web
$contenu = "";

// chemins :
define('RACINE_SITE', '/PHP/site/'); // création du chemin du site à partir de htdocs
define('RACINE_SERVEUR', $_SERVER['DOCUMENT_ROOT']); // création du chemin du serveur grâce à la superglobale $_SERVER

// autres inclusions :
require_once('fonctions.inc.php');
?>