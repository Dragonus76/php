<?php
echo '<pre>';
print_r($_POST);
echo '</pre>';

$msg='';

if($_POST){
	if(empty($_POST['auteur']) || empty($_POST['titre'])){
		$msg = '<strong style="background: red;">Veuillez renseigner tous les champs!</strong>';
	}
	if(strlen($_POST['auteur'])>25){
		$msg = '<strong style="background: red;">Le champs "auteur" ne doit pas comporter plus de 25 caratères</strong>';
	}
	if(strlen($_POST['titre'])>50){
		$msg = '<strong style="background: red;">Le champs "titre" ne doit pas comporter plus de 50 caratères</strong>';
	}
	if(empty($msg)){
		$msg = '<strong style="background: green;">Félicitation, vous avez ajouté un livre</strong>';
	}
}
?>

<h1>Ajout d'un livre</h1>

<form method="post" action="">
	<label>Auteur</label>
	<input type="text" name="auteur"><br><br>
	
	<label>Titre</label>
	<input type="text" name="titre"><br><br>
	
	<input type="submit" value="Enregistrement">
</form>

<?= $msg ?>