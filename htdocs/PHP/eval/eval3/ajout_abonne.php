<?php
echo '<pre>';
print_r($_POST);
echo '</pre>';

$msg='';

if($_POST){
	if(empty($_POST['prenom']) || empty($_POST['nom'])){
		$msg = '<strong style="background: red;">Veuillez renseigner tous les champs!</strong>';
	}
	if(strlen($_POST['prenom'])>30 || strlen($_POST['nom'])>30){
		$msg = '<strong style="background: red;">Les champs ne doivent pas comporter plus de 30 caratères</strong>';
	}
	if(empty($msg)){
		$msg = '<strong style="background: green;">Félicitation, vous êtes inscrits</strong>';
	}
}
?>

<h1>Ajout d'un abonné</h1>

<form method="post" action="">
	<label>Prénom</label>
	<input type="text" name="prenom"><br><br>
	
	<label>Nom</label>
	<input type="text" name="nom"><br><br>
	
	<input type="submit" value="Enregistrement">
</form>

<?= $msg ?>