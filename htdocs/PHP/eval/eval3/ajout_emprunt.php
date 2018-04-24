<?php
$pdo = new PDO('mysql:host=localhost;dbname=bibliotheque', 'root', '');

/*
echo '<pre>';
print_r($_POST);
echo '</pre>';
*/

if($_POST){
	
	// Définition de date_sortie
	$date_sortie = $_POST['annee_sortie'] . '-' . $_POST['mois_sortie'] . '-' . $_POST['jour_sortie'];
	
	// Définition de date_rendu
	if($_POST[jour_rendu]=='jj' && $_POST[mois_rendu]=='mm' && $_POST[annee_rendu]=='aaaa'){
		$date_rendu = "null";
	}
	else{
		$date_rendu = $_POST['annee_rendu'] . '-' . $_POST['mois_rendu'] . '-' . $_POST['jour_rendu'];
	}
	
	/* $resultat = $pdo -> prepare("INSERT INTO emprunt(id_abonne, id_livre, date_sortie, date_rendu) VALUES(:id_abonne, :id_livre, :date_sortie, :date_rendu)");
	
	$resultat -> bindParam(':id_abonne', $_POST['nom'], PDO::PARAM_STR); */
	


?>

<h1>Ajout d'un emprunt</h1>

<form method="post" action="">
	<label>Abonné</label>
	<select name="abonne">
		<?php
		$resultat = $pdo -> query("SELECT * FROM abonne");
		while($abonne = $resultat -> fetch(PDO::FETCH_ASSOC)){
						
			$choix_abonne = '<option>' . $abonne['id_abonne'] . '-' . $abonne['prenom'] . ' ' . $abonne['nom'] . '</option><br>';
			echo $choix_abonne;
		}
		?>
	</select><br><br>
	
	<label>Livre</label>
	<select name="livre">
		<?php 
		$resultat = $pdo -> query("SELECT * FROM livre");
		while($livre = $resultat -> fetch(PDO::FETCH_ASSOC)){
					
			$choix_livre = '<option>' . $livre['id_livre'] . '-' . $livre['auteur'] . '-' . $livre['titre'] . '</option><br>';
			echo $choix_livre;
		}
		?>
	</select><br><br>
	
	<label>Date de sortie<label><br/>
	<select name="jour_sortie">
		<?php for($i= 1; $i <= 31; $i++) : ?>
		<option><?= substr('0'.$i, -2) ?></option>
		<?php endfor; ?>
	</select>
	
	<select name="mois_sortie">
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
	
	<select name="annee_sortie">
		<?php 
		$i = date('Y');
		while($i >= 2011){
			echo '<option>'. $i .'</option>';
			$i--;
		}
		?>
	</select><br/><br/>
	
	<label>Date de rendu<label><br/>
	<select name="jour_rendu">
		<option>jj</option>
		<?php for($i= 1; $i <= 31; $i++) : ?>
		<option><?= substr('0'.$i, -2) ?></option>
		<?php endfor; ?>
	</select>
	
	<select name="mois-rendu">
		<option value="00">mm</option>
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
	
	<select name="annee_rendu">
		<option>aaaa</option>
		<?php 
		$i = date('Y');
		while($i >= 2011){
			echo '<option>'. $i .'</option>';
			$i--;
		}
		?>
	</select><br/><br/>
	
	<input type="submit" value="Enregistrement">
</form>