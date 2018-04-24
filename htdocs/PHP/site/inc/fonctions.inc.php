<?php
// fonction pour afficher les print_r()
function debug($tab){

	echo '<div style="color: white; font-weight: bold; padding: 20px; background:#' . rand(111111, 999999) . ' ">';

	$trace = debug_backtrace(); // debug_backtrace() nous permet de récupérer plusieurs infos sur l'endroit où une fonction est appelée (exécutée).

	echo 'Le debug a été demandé dans le fichier ' . $trace[0]['file'

] . ' à la ligne ' . $trace[0]['line'] . '<hr>';

	echo '<pre>';
	print_r($tab);
	echo '</pre>';

	echo '</div>';
}

// fonction pour savoir si user est connecté
function userConnect(){
	if(isset($_SESSION['membre'])){
		return TRUE;
	}
	else{
		return FALSE;
	}
}

// fonction pour vérifier si user est admin
function userAdmin(){
	if(userConnect() && $_SESSION['membre']['statut'] == 1){
		return TRUE;
	}
	else{
		return FALSE;
	}

}

// fonction pour ajouter un produit au panier
function ajouterProduit(){
	
}

?>
