<?php

//profil.php?id=12

//SELECT * FROM membre WHERE id_membre = $_GET['id']

$membre = array(
	'pseudo' => 'Toto',
	'prenom' => 'toto',
	'email' => 'toto@gmail.com'
);

echo 'Bonjour' . $membre['pseudo'] . '<br>';
echo 'Voici vos informations personnelles : <br>';

echo '<ul>';
foreach($membre as $indice => $valeur){
	echo '<li>' . $indice . ' : ' . $valeur . '</li>';
}
echo '</ul>';







?>