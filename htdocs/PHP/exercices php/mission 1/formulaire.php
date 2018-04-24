<?php

/*
echo '<pre>';
print_r($_POST)
;echo '</pre>';
*/

if($_POST){
	
	foreach($_POST as $indice => $valeur){
		
		echo ucfirst(str_replace('_', ' ', ($indice))) . ' : <strong>' . $valeur . '</strong><br>';
			//ici on utilise str_replace pour l'underscore de code_postal
		
		//strtoupper() => tout en majuscule
		//strtolower() => tout en minuscule
		//ucfirst()    => première lettre en majuscule
		
		//str_replace() => remplacer dans une CC un caractère par un autre. Prend 3 arguments :
			//1- le caractère à remplacer
			//2- le caractère remplaçant
			//3- la CC
		
	}
	
}

?>


<h1>Mission 1</h1>

<form method="post" action="">
	<label>Nom :</label><br>
	<input type="text" name="nom"><br><br>
	
	<label>Prénom :</label><br>
	<input type="text" name="prenom"><br><br>
	
	<label>Adresse :</label><br>
	<input type="text" name="adresse"><br><br>
	
	<label>Ville :</label><br>
	<input type="text" name="ville"><br><br>
	
	<label>Code Postal :</label><br>
	<input type="text" name="code_postal"><br><br>
	
	<label>Sexe :</label><br>
	<select name="sexe">
		<option>Homme</option>
		<option>Femme</option>
	</select><br><br>
	
	<label>Description :</label><br>
	<textarea name="description" row="10" cols="30"></textarea><br><br>
	
	<input type="submit" value="Envoi">
</form>