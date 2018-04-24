<?php
// $_GET représente l'url. Il s'agit d'une SUPERGLOBALE, elle appartient au langage, et s'écrit obligatoirement en MAJ et avec un underscore.
// Comme toutes les SUPERGLOBALES, $_GET est un tableau de données ARRAY.
// Les paramètres d'url sont toujours constitués d'une clé et d'une valeur qui deviendront les indices et valeurs de notre array.

// page2.php ? article=jean & couleur=bleu & prix=10
// chemin    ? clé=valeur   & clé=valeur   & clé=valeur
    
if(!empty($_GET)){
	echo '<pre>';
	print_r($_GET);
	echo '</pre>';
	
	if(isset($_GET['article']) && isset($_GET['couleur']) && isset($_GET['prix'])){
		echo 'paramètre article : ' . $_GET['article'] . '<br>';
		echo 'paramètre couleur : ' . $_GET['couleur'] . '<br>';
		echo 'paramètre prix : ' . $_GET['prix'] . '<br>';
	}
}
else{
	// redirection vers une page 404
}


?>

<h1>Page 2</h1>
<a href="page1.php">Lien vers la page 1</a>
