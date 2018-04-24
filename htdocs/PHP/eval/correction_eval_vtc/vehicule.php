<?php
require('inc/init.inc.php');

// On récupère tous les conducteurs : 
$resultat = $pdo -> query("SELECT * FROM vehicule");
$vehicules = $resultat -> fetchAll(PDO::FETCH_ASSOC);


// Traitement pour ajouter un conducteur (ou modifier) : 
if($_POST){
	print_r($_POST);
	if(!empty($_POST['marque']) && !empty($_POST['modele']) && !empty($_POST['couleur']) && !empty($_POST['immatriculation'])){
		if(!empty($_POST['id_vehicule'])){
			$resultat = $pdo -> prepare("UPDATE vehicule SET  marque = :marque, modele =:modele, couleur=:couleur, immatriculation= :immatriculation WHERE id_vehicule = :id");
			$resultat -> bindParam(':id', $_GET['id_vehicule'], PDO::PARAM_INT);
		}
		else{
			$resultat = $pdo -> prepare("INSERT INTO vehicule (marque, modele, couleur, immatriculation) VALUES (:marque, :modele, :couleur, :immatriculation)");
		}
		
		$resultat -> bindParam(':marque', $_POST['marque'], PDO::PARAM_STR);
		$resultat -> bindParam(':modele', $_POST['modele'], PDO::PARAM_STR);
		$resultat -> bindParam(':couleur', $_POST['couleur'], PDO::PARAM_STR);
		$resultat -> bindParam(':immatriculation', $_POST['immatriculation'], PDO::PARAM_STR);
		if($resultat -> execute()){
			header('location:vehicule.php');
		}
	}
	else{
		$msg .= '<div class="alert alert-danger"><strong>Attention !</strong> Veuillez renseigner tous les champs.</div>';
	}
}

// Traitement pour supprimer un véhicule  : 
if(isset($_GET['action']) && $_GET['action'] == 'suppression'){
	if(isset($_GET['id_vehicule']) && !empty($_GET['id_vehicule']) && is_numeric($_GET['id_vehicule'])){
		
		$resultat = $pdo -> prepare('SELECT * FROM vehicule WHERE id_vehicule = :id');
		$resultat -> bindParam(':id', $_GET['id_vehicule'], PDO::PARAM_INT);
		$resultat -> execute();
		
		if($resultat -> rowCount() > 0){
			$vehicule_a_supprimer = $resultat -> fetch(PDO::FETCH_ASSOC);
			$resultat = $pdo -> exec("DELETE FROM vehicule WHERE id_vehicule = $vehicule_a_supprimer[id_vehicule]");
			header('location:vehicule.php');
		}
	}	
}


// Traitement pour récupérer les infos d'un conducteur à modifier : 
if(isset($_GET['action']) && $_GET['action'] == 'modification'){
	if(isset($_GET['id_vehicule']) && !empty($_GET['id_vehicule']) && is_numeric($_GET['id_vehicule'])){
		
		$resultat = $pdo -> prepare('SELECT * FROM vehicule WHERE id_vehicule = :id');
		$resultat -> bindParam(':id', $_GET['id_vehicule'], PDO::PARAM_INT);
		$resultat -> execute();
		
		if($resultat -> rowCount() > 0){
			$vehicule_actuel = $resultat -> fetch(PDO::FETCH_ASSOC);
		}
	}	
}

$marque = (isset($vehicule_actuel)) ? $vehicule_actuel['marque'] : '';
$modele = (isset($vehicule_actuel)) ? $vehicule_actuel['modele'] : '';
$couleur= (isset($vehicule_actuel)) ? $vehicule_actuel['couleur'] : '';
$immatriculation = (isset($vehicule_actuel)) ? $vehicule_actuel['immatriculation'] : '';
$id_vehicule = (isset($vehicule_actuel)) ? $vehicule_actuel['id_vehicule'] : '';
$action = (isset($vehicule_actuel)) ? 'Modifier' : 'Ajouter';



require('inc/header.inc.php');
?>

<!-- CONTENU HTML -->
<h1>Véhicules</h1>

<table class="table">
	<tr>
	<?php for($i=0; $i<$resultat->columnCount(); $i++) : ?>
	<?php $colonne = $resultat->getColumnMeta($i); ?>	
		<th><?= str_replace('_', ' ', ucfirst($colonne['name'])) ?></th>
	<?php endfor; ?>
		<th>Modification</th>
		<th>Suppression</th>
	</tr>
	
	<?php foreach($vehicules as $vehicule) : ?>
	<tr>
		<?php foreach($vehicule as $infos) : ?>
		<td><?= $infos ?></td>
		<?php endforeach; ?>
		<td><a href="?action=modification&id_vehicule=<?= $vehicule['id_vehicule'] ?>"><span class="glyphicon glyphicon-pencil"></span></a></td>
		<td><a href="?action=suppression&id_vehicule=<?= $vehicule['id_vehicule'] ?>"><span class="glyphicon glyphicon-remove"></span></a></td>
	</tr>
	<?php endforeach; ?>
</table>

<hr/>
<h4>Formulaire pour <?= $action ?> un vehicule</h4>
<form method="post" action="">
	<?= $msg ?>
 <div class="form-group">
	<input type="hidden" name="id_vehicule" value="<?= $id_vehicule ?>"/>
	<label for="marque">Marque</label>
	<input type="text" name="marque" id="Marque" class="form-control" placeholder="marque" value="<?= $marque ?>"><br>
	
	<label for="modele">Modele</label>
	<input type="text" name="modele" id="modele" class="form-control" placeholder="modele" value="<?= $modele ?>"><br>
	
	<label for="couleur">Couleur</label>
	<input type="text" name="couleur" id="couleur" class="form-control" placeholder="couleur" value="<?= $couleur ?>"><br>
	
	<label for="immatriculation">Immatriculation</label>
	<input type="text" name="immatriculation" id="immatriculation" class="form-control" placeholder="immatriculation" value="<?= $immatriculation ?>"><br>
	
	
	
	
	<input type="submit" name="ajouter" value="<?= $action ?> ce véhicule" class="btn btn-default">
</div>
</form>







<?php
require('inc/footer.inc.php');
?>