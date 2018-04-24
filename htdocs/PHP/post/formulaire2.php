<?php

$msg = ''; // variable vide à déclarer AU DEBUT

if($_POST){// Si le formulaire est activé
	
	echo '<pre>';
	print_r($_POST);
	echo '</pre>';
	
	// vérifications(taille, chiffre ou string, ...)
	
	// vérifier que les champs ne sont pas vides
	foreach($_POST as $indice => $valeur){
		if(empty($valeur)){
			$msg = '<p style="background: red; padding: 5px; color: white;">Attention, veuillez renseigner le champs ' . $indice . '</p>';
		}
	}
	
	if(empty($msg)){ // Si $msg est vide c'est qu'on n'a enregistré aucune erreur. On peut donc effectuer le traitement final.
		$msg = 'Félicitation, vos informations sont enregistrées !';
	}
	
	// requete INSERT pour enregistrer les infos en BDD
	
}


?>


<h1>Formulaire 2</h1>
<?= $msg; ?>

<!--
ville(text)
code_postal(text)
adresse(textarea)
envoyer(submit)
-->

<form method="post" action="">
	<label>Ville :</label><br>
	<input type="text" name="ville" value="<?php if(isset($_POST['ville'])){echo $_POST['ville'];} ?>"><br><br>
	
	<label>Code postal :</label><br>
	<input type="text" name="code_postal"><br><br>
	
	<label>Adresse :</label><br>
	<textarea name="adresse" row="5" cols="22"></textarea><br><br>
	
	<input type="submit" value="Envoyer">
</form>