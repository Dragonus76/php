<?php 

//Connexion BDD : 
$pdo = new PDO('mysql:host=localhost;dbname=vtc', 'root', '', array( 
	PDO::ATTR_ERRMODE => PDO::ERRMODE_WARNING
));

// Variables : 
$msg = '';