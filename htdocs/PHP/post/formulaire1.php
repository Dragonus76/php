<?php
// $_POST représente les informations récupérées depuis le formualire, A CONDITION d'avoir choisi la méthode POST.
// $_POST est une SUPERGLOBALE qui appartient au langage, et s'écrit obligatoirement en MAJUSCULE avec un underscore.
// COmme toutes les SUPERGLOBALES, $_POST est un tableau de données ARRAY.
// Les "name" des champs deviennent les indices de l'ARRAY, et les information saisies, les valeurs.

if(!empty($_POST)){ //vérifie si le formulaire est activé
	echo '<pre>';
	print_r($_POST);
	echo '</pre>';

	echo 'Prénom : ' . $_POST['prenom'] . '<br>';
	echo 'Description : ' . $_POST['description'] . '<br>';
}

?>


<h1>Formulaire 1</h1>
<!-- 
prenom (text)
description (textarea)
envoyer(submit)
-->

<form method="post" action="">
	<label>Prénom : </label><br>
	<input type="text" name="prenom"><br><br>
	
	<label>Description : </label><br>
	<textarea name="description" row="5" cols="22"></textarea><br><br>
	
	<input type="submit" value="Envoyer">
</form>


