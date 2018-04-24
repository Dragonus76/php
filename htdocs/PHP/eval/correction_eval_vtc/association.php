<?php
require('inc/init.inc.php');

// On récupère tous les associations : 
$resultat = $pdo -> query("SELECT c.*, v.*, a.* FROM association_vehicule_conducteur a, vehicule v, conducteur c WHERE c.id_conducteur = a.id_conducteur AND v.id_vehicule = a.id_vehicule");
$associations = $resultat -> fetchAll(PDO::FETCH_ASSOC);

// On récupère tous les conducteurs : 
$resultat = $pdo -> query("SELECT * FROM vehicule");
$vehicules = $resultat -> fetchAll(PDO::FETCH_ASSOC);


// On récupère tous les conducteurs : 
$resultat = $pdo -> query("SELECT * FROM conducteur");
$conducteurs = $resultat -> fetchAll(PDO::FETCH_ASSOC);

// traitement pour enregistrer les associations : 
if($_POST){
	print_r($_POST);
	if(!empty($_POST['conducteur']) && !empty($_POST['vehicule']) && $_POST['vehicule'] !== 0 &&  $_POST['conducteur'] !== 0 ){
		if(!empty($_POST['id_association'])){
			$resultat = $pdo -> prepare("UPDATE association_vehicule_conducteur SET  id_vehicule = :id_vehicule, id_conducteur =:id_conducteur WHERE id_association = :id");
			$resultat -> bindParam(':id', $_GET['id_association'], PDO::PARAM_INT);
		}
		else{
			$resultat = $pdo -> prepare("INSERT INTO association_vehicule_conducteur (id_vehicule, id_conducteur) VALUES (:id_vehicule, :id_conducteur)");
		}
		
		$resultat -> bindParam(':id_vehicule', $_POST['vehicule'], PDO::PARAM_STR);
		$resultat -> bindParam(':id_conducteur', $_POST['conducteur'], PDO::PARAM_STR);
		if($resultat -> execute()){
			header('location:association.php');
		}
	}
	else{
		$msg .= '<div class="alert alert-danger"><strong>Attention !</strong> Veuillez renseigner tous les champs.</div>';
	}
}

// Traitement pour supprimer un conducteur  : 
if(isset($_GET['action']) && $_GET['action'] == 'suppression'){
	if(isset($_GET['id_association']) && !empty($_GET['id_association']) && is_numeric($_GET['id_association'])){
		
		$resultat = $pdo -> prepare('SELECT * FROM association_vehicule_conducteur WHERE id_association = :id');
		$resultat -> bindParam(':id', $_GET['id_association'], PDO::PARAM_INT);
		$resultat -> execute();
		
		if($resultat -> rowCount() > 0){
			$asso_a_supprimer = $resultat -> fetch(PDO::FETCH_ASSOC);
			
			print_r($asso_a_supprimer);
			
			$resultat = $pdo -> exec("DELETE FROM association_vehicule_conducteur WHERE id_association = $asso_a_supprimer[id_association]");
			header('location:association.php');
		}
	}	
}







// Traitement pour récupérer les infos d'une asso à modifier: 
if(isset($_GET['action']) && $_GET['action'] == 'modification'){
	if(isset($_GET['id_association']) && !empty($_GET['id_association']) && is_numeric($_GET['id_association'])){
		
		$resultat = $pdo -> prepare('SELECT * FROM association_vehicule_conducteur WHERE id_association = :id');
		$resultat -> bindParam(':id', $_GET['id_association'], PDO::PARAM_INT);
		$resultat -> execute();
		
		if($resultat -> rowCount() > 0){
			$association_actuelle = $resultat -> fetch(PDO::FETCH_ASSOC);
		}
	}	
}

$id_conducteur = (isset($association_actuelle)) ? $association_actuelle['id_conducteur'] : '';
$id_vehicule = (isset($association_actuelle)) ? $association_actuelle['id_vehicule'] : '';
$id_association = (isset($association_actuelle)) ? $association_actuelle['id_association'] : '';
$action = (isset($association_actuelle)) ? 'Modifier' : 'Ajouter';


require('inc/header.inc.php');

?>

<!-- CONTENU HTML -->
<h1>Associations Conducteurs >> Véhicules </h1>
<table class="table">
	<tr>
		<th>Id Association</th>
		<th>Conducteur</th>
		<th>Véhicule</th>
		<th>Modification</th>
		<th>Suppression</th>
	</tr>
	
	<?php foreach($associations as $asso) : ?>
	<tr>
		<td><?= $asso['id_association'] ?></td>
		<td><?= $asso['prenom'] ?> <?= strtoupper($asso['nom']) ?> <br/> <?= $asso['id_conducteur'] ?></td>
		<td><?= $asso['marque'] ?> <?= strtoupper($asso['modele']) ?> <br/> <?= $asso['id_vehicule'] ?></td>
		<td><a href="?action=modification&id_association=<?= $asso['id_association'] ?>"><span class="glyphicon glyphicon-pencil"></span></a></td>
		<td><a href="?action=suppression&id_association=<?= $asso['id_association'] ?>"><span class="glyphicon glyphicon-remove"></span></a></td>
	</tr>
	<?php endforeach; ?>
</table>

<hr/>
<h4>Formulaire pour ajouter une association</h4>
<form method="post" action="">
	<?= $msg ?>
	<div class="form-group">
		<input type="hidden" name="id_association" value="<?= $id_association ?>"  />
		<label>Conducteur</label>
		<select  class="form-control"  name="conducteur">
			<option value="0">Choisirle conducteur</option>
			<?php foreach($conducteurs as $conducteur) : ?>
				<option <?= ($id_conducteur == $conducteur['id_conducteur']) ? 'selected' : ''  ?> value="<?= $conducteur['id_conducteur'] ?>"><?= $conducteur['id_conducteur'] ?> - <?= $conducteur['prenom'] ?> <?= strtoupper($conducteur['nom']) ?></option>
			<?php endforeach; ?>
		</select><br/>
		<label>Véhicule</label>
		<select  class="form-control"  name="vehicule">
			<option value="0">Choisir le véhicule</option>
			<?php foreach($vehicules as $vehicule) : ?>
				<option  <?= ($id_vehicule == $vehicule['id_vehicule']) ? 'selected' : ''  ?> value="<?= $vehicule['id_vehicule'] ?>"><?= $vehicule['id_vehicule'] ?> - <?= $vehicule['marque'] ?> <?= $vehicule['modele'] ?> (<?= $vehicule['couleur'] ?>)</option>
			<?php endforeach; ?>
		</select><br/>
		<input type="submit" name="ajouter" value="<?= $action ?> cette association" class="btn btn-default">
	</div>
</form>




<?php
require('inc/footer.inc.php');
?>