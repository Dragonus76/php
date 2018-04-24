<?php
require_once('inc/init.inc.php');

if (isset($_GET['id']) && !empty($_GET['id']) && is_numeric($_GET['id'])){
	debug($_GET);

	$resultat = $pdo -> prepare("SELECT * FROM produit WHERE id_produit = :id_produit");
	$resultat -> bindParam(':id_produit', $_GET['id'], PDO::PARAM_INT);
	$resultat -> execute();

	if ($resultat -> rowCount() > 0 ) { // le produit existe en BDD
		$produit = $resultat -> fetch();
		debug($produit);
		extract($produit);
	}
	else{
		header('location:boutique.php');
	}

}
else{
	header('location:boutique.php');
}

if ($_POST) { // Si la personne clique sur ajouter au panier :
	if (!empty($_POST['quantite']) && is_numeric($_POST['quantite']) && $_POST['quantite'] != 0) {
		ajouterProduit($id_produit, $_POST['quantite'], $photo, $titre, $prix);
	}
	

}




$page = 'Fiche_produit';
require_once('inc/header.inc.php');
?>

<!-- Contenu HTML -->
<a href="boutique.php">Retour boutique</a>
<h1><?= $titre ?></h1>

<img src="photo/<?= $photo ?>" width="250">

	
<p>Détails du produit :</p>
<ul>
	<li>Référence : <b><?= $reference ?></b></li>
	<li>categorie : <b><?= $categorie ?></b></li>
	<li>Couleur : <b><?= $couleur ?></b></li>
	<li>Taille : <b><?= $taille ?></b></li>
	<li>Public : <b><?php 
		if ($public == 'm') {echo 'Homme';} elseif ($public == 'f') {echo 'Femme';}	else{echo 'mixte';} ?></b></li>
	<li>Prix : <b style="color: red; font-style: 20px"><?= $prix ?>€ TTC</b></li>
</ul><br>
<p>Description du produit : <br>
	<em><?= $description ?></em></p>

<fieldset>
	<legend>Acheter ce produit :</legend>
	<form method="post" action="">
		<label>Quantité</label>
		<select name="quantite">
			<?php
			for ($i=1; $i <= 5 && $i <= $stock ; $i++) { 
				echo '<option>' . $i . '</option>';
			}
			?>
		</select>
		<input type="submit" value="Ajouter au panier">
	</form>
</fieldset>

<div class="profil">
	<h2>Suggestions de produits :</h2>

	<!-- Vignette produit -->
	<div class="boutique-produit">
		<h3>Titre du produit</h3>
		<a href=""><img src="photo/jaune.png" height="100"></a>
		<p style="font-weight: bold; font-size: 20px;">50€</p>
		<p style="height: 40px;">Description...</p>
		<a style="padding: 5px 15px; border: 1px solid red; color: red; border-radius: 4px" href="">Voir le produit</a>
	</div>
	<!-- Fin vignette produit -->

	<!-- Vignette produit -->
	<div class="boutique-produit">
		<h3>Titre du produit</h3>
		<a href=""><img src="photo/jaune.png" height="100"></a>
		<p style="font-weight: bold; font-size: 20px;">50€</p>
		<p style="height: 40px;">Description...</p>
		<a style="padding: 5px 15px; border: 1px solid red; color: red; border-radius: 4px" href="">Voir le produit</a>
	</div>
	<!-- Fin vignette produit -->

	<!-- Vignette produit -->
	<div class="boutique-produit">
		<h3>Titre du produit</h3>
		<a href=""><img src="photo/jaune.png" height="100"></a>
		<p style="font-weight: bold; font-size: 20px;">50€</p>
		<p style="height: 40px;">Description...</p>
		<a style="padding: 5px 15px; border: 1px solid red; color: red; border-radius: 4px" href="">Voir le produit</a>
	</div>
	<!-- Fin vignette produit -->

</div>








<?php
require('inc/footer.inc.php');
?>