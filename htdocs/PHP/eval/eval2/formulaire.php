<?php
$pdo = new PDO('mysql:host=localhost;dbname=repertoire', 'root', '', array(
	PDO::ATTR_ERRMODE => PDO::ERRMODE_WARNING
));

$msg = '';

if($_POST){
	
	// echo '<pre>'; 
	// print_r($_POST);
	// echo '</pre>';	
	
	if(empty($_POST['nom'])){	
		$msg .= '<p style="color: white; background:red; padding: 5px" >Le champs nom est obligatoire</p>';
	}
	
	if(empty($_POST['prenom'])){	
		$msg .= '<p style="color: white; background:red; padding: 5px" >Le champs prénom est obligatoire</p>';
	}
	
	if(strlen($_POST['telephone']) > 10){
		$msg .= '<p style="color: white; background:red; padding: 5px" >Attention le champs téléphone doit comporter 10 caractères max !</p>';
	}


	if(empty($msg)){ // Cela signifie que tout est OK, je ne suis pas passé dans les IF des erreurs, le formulaire est bien rempli, on peut enregistrer les infos dans annuaire.

		foreach($_POST as $indice => $valeur){
			$_POST[$indice] = htmlentities(addslashes($valeur));
		}
		
		$date_naissance = $_POST['annees'] . '-' . $_POST['mois'] . '-' . $_POST['jours'];
		// 2005-12-14
	
		$resultat = $pdo -> prepare( "INSERT INTO annuaire(nom, prenom, telephone, profession, ville, codepostal, adresse, date_de_naissance, sexe, description) VALUES(:nom, :prenom, :telephone, :profession, :ville, :codepostal, :adresse, :date_de_naissance, :sexe, :description) ");

		$resultat -> bindParam(':nom', $_POST['nom'], PDO::PARAM_STR);
		$resultat -> bindParam(':prenom', $_POST['prenom'], PDO::PARAM_STR);
		$resultat -> bindParam(':profession', $_POST['profession'], PDO::PARAM_STR);
		$resultat -> bindParam(':ville', $_POST['ville'], PDO::PARAM_STR);
		$resultat -> bindParam(':adresse', $_POST['adresse'], PDO::PARAM_STR);
		$resultat -> bindParam(':date_de_naissance', $date_naissance, PDO::PARAM_STR);
		$resultat -> bindParam(':sexe', $_POST['sexe'], PDO::PARAM_STR);
		$resultat -> bindParam(':description', $_POST['description'], PDO::PARAM_STR);
		
		$resultat -> bindParam(':telephone', $_POST['telephone'], PDO::PARAM_INT);
		$resultat -> bindParam(':codepostal', $_POST['codepostal'], PDO::PARAM_INT);
	
		if($resultat -> execute()){ // si $resultat -> execute() est TRUE = si la requete s'est bien passée...
			header('location:affichage.php');
			$msg .= '<p style="color: white; background:green; padding: 5px" >Félicitations, l\'enregistrement s\'est bien déroulé !</p>';
		}
	}
}
?>

<h1>Formulaire Annuaire</h1>
<?= $msg ?>
<form action="" method="post">

	<label>Nom* :<label><br/>
	<input type="text" name="nom"/><br/><br/>

	<label>Prénom* :<label><br/>
	<input type="text" name="prenom" /><br/><br/>
	
	<label>Téléphone* :<label><br/>
	<input type="text" name="telephone" /><br/><br/>
	
	<label>Profession :<label><br/>
	<input type="text" name="profession" /><br/><br/>
	
	<label>Ville :<label><br/>
	<input type="text" name="ville" /><br/><br/>
	
	<label>Code postal :<label><br/>
	<input type="text" name="codepostal" /><br/><br/>
	
	<label>Adresse :<label><br/>
	<textarea name="adresse" rows="10" cols="30"></textarea><br/><br/>

	<label>Date de naissance :<label><br/>
	<select name="jours">
		<?php for($i= 1; $i <= 31; $i++) : ?>
		<option><?= substr('0'.$i, -2) ?></option>
		<?php endfor; ?>
	</select>
	
	<select name="mois">
		<option value="01">Janvier</option>
		<option value="02">Février</option>
		<option value="03">Mars</option>
		<option value="04">Avril</option>
		<option value="05">Mai</option>
		<option value="06">Juin</option>
		<option value="07">Juillet</option>
		<option value="08">Aout</option>
		<option value="09">Septembre</option>
		<option value="10">Octobre</option>
		<option value="11">Novembre</option>
		<option value="12">Décembre</option>
	</select>
	
	<select name="annees">
		<?php 
		$i = date('Y');
		while($i >= 1900){
			echo '<option>'. $i .'</option>';
			$i--;
		}
		?>
	</select><br/><br/>
	
	<label>Sexe :</label><br/>
	<select name="sexe">
		<option value="m">Homme</option>
		<option  value="f">Femme</option>
	</select><br/><br/>

	<label>Description :<label><br/>
	<textarea name="description" rows="10" cols="30"></textarea><br/><br/>
	
	<input type="submit" value="Enregistrer" />
</form>
