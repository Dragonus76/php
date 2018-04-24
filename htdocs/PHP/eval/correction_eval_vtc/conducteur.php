<?php
require('inc/init.inc.php');

// On récupère tous les conducteurs : 
$resultat = $pdo -> query("SELECT * FROM conducteur");
$conducteurs = $resultat -> fetchAll(PDO::FETCH_ASSOC);


// Traitement pour ajouter un conducteur (ou modifier) : 
if($_POST){
	print_r($_POST);
	if(!empty($_POST['prenom']) && !empty($_POST['nom']) ){
		if(!empty($_POST['id_conducteur'])){
			$resultat = $pdo -> prepare("UPDATE conducteur SET  prenom = :prenom, nom =:nom WHERE id_conducteur = :id");
			$resultat -> bindParam(':id', $_GET['id_conducteur'], PDO::PARAM_INT);
		}
		else{
			$resultat = $pdo -> prepare("INSERT INTO conducteur (prenom, nom) VALUES (:prenom, :nom)");
		}
		
		$resultat -> bindParam(':prenom', $_POST['prenom'], PDO::PARAM_STR);
		$resultat -> bindParam(':nom', $_POST['nom'], PDO::PARAM_STR);
		if($resultat -> execute()){
			header('location:conducteur.php');
		}
	}
	else{
		$msg .= '<div class="alert alert-danger"><strong>Attention !</strong> Veuillez renseigner tous les champs.</div>';
	}
}

// Traitement pour supprimer un conducteur  : 
if(isset($_GET['action']) && $_GET['action'] == 'suppression'){
	if(isset($_GET['id_conducteur']) && !empty($_GET['id_conducteur']) && is_numeric($_GET['id_conducteur'])){
		
		$resultat = $pdo -> prepare('SELECT * FROM conducteur WHERE id_conducteur = :id');
		$resultat -> bindParam(':id', $_GET['id_conducteur'], PDO::PARAM_INT);
		$resultat -> execute();
		
		if($resultat -> rowCount() > 0){
			$conducteur_a_supprimer = $resultat -> fetch(PDO::FETCH_ASSOC);
			$resultat = $pdo -> exec("DELETE FROM conducteur WHERE id_conducteur = $conducteur_a_supprimer[id_conducteur]");
			header('location:conducteur.php');
		}
	}	
}


// Traitement pour récupérer les infos d'un conducteur à modifier : 
if(isset($_GET['action']) && $_GET['action'] == 'modification'){
	if(isset($_GET['id_conducteur']) && !empty($_GET['id_conducteur']) && is_numeric($_GET['id_conducteur'])){
		
		$resultat = $pdo -> prepare('SELECT * FROM conducteur WHERE id_conducteur = :id');
		$resultat -> bindParam(':id', $_GET['id_conducteur'], PDO::PARAM_INT);
		$resultat -> execute();
		
		if($resultat -> rowCount() > 0){
			$conducteur_actuel = $resultat -> fetch(PDO::FETCH_ASSOC);
		}
	}	
}

$prenom = (isset($conducteur_actuel)) ? $conducteur_actuel['prenom'] : '';
$nom = (isset($conducteur_actuel)) ? $conducteur_actuel['nom'] : '';
$id_conducteur = (isset($conducteur_actuel)) ? $conducteur_actuel['id_conducteur'] : '';
$action = (isset($conducteur_actuel)) ? 'Modifier' : 'Ajouter';



require('inc/header.inc.php');
?>

<!-- CONTENU HTML -->
<h1>Conducteurs</h1>

<table class="table">
	<tr>
	<?php for($i=0; $i<$resultat->columnCount(); $i++) : ?>
	<?php $colonne = $resultat->getColumnMeta($i); ?>	
		<th><?= str_replace('_', ' ', ucfirst($colonne['name'])) ?></th>
	<?php endfor; ?>
		<th>Modification</th>
		<th>Suppression</th>
	</tr>
	
	<?php foreach($conducteurs as $conducteur) : ?>
	<tr>
		<?php foreach($conducteur as $infos) : ?>
		<td><?= $infos ?></td>
		<?php endforeach; ?>
		<td><a href="?action=modification&id_conducteur=<?= $conducteur['id_conducteur'] ?>"><span class="glyphicon glyphicon-pencil"></span></a></td>
		<td><a href="?action=suppression&id_conducteur=<?= $conducteur['id_conducteur'] ?>"><span class="glyphicon glyphicon-remove"></span></a></td>
	</tr>
	<?php endforeach; ?>
</table>

<hr/>
<h4>Formulaire pour <?= $action ?> un conducteur</h4>
<form method="post" action="">
	<?= $msg ?>
 <div class="form-group">
	<input type="hidden" name="id_conducteur" value="<?= $id_conducteur ?>"/>
	<label for="prenom">Prenom</label>
	<input type="text" name="prenom" id="prenom" class="form-control" placeholder="prenom" value="<?= $prenom ?>"><br>
	
	<label for="nom">nom</label>
	<input type="text" name="nom" id="nom" class="form-control" placeholder="nom" value="<?= $nom ?>"><br>
	
	<input type="submit" name="ajouter" value="<?= $action ?> ce conducteur" class="btn btn-default">
</div>
</form>







<?php
require('inc/footer.inc.php');
?>