<?php
require_once('inc/init.inc.php');

// Faire une requête et stocker son résultat pour récupérer toutes les catégories de nos produits (DISTINCT)
$resultat = $pdo -> query("SELECT DISTINCT categorie FROM produit");

$categorie = $resultat -> fetchAll(PDO::FETCH_ASSOC);
debug($categorie);
 
// s'il y a une catégorie précisée dans l'url, la requête qui va chercher tous les produits ciblera les produits de la catégorie sélectionnée en url
if (isset($_GET['categorie']) && !empty($_GET['categorie'])){
	debug($_GET);
	$resultat = $pdo -> prepare("SELECT * FROM produit WHERE categorie = :categorie");
	$resultat -> bindParam(':categorie', $_GET['categorie'], PDO::PARAM_STR);
	$resultat -> execute();

	if ($resultat -> rowCount() == 0) {	//si qq'un s'amuse à taper categorie=toto dans l'url alors on le redirige vers la page 
		header('location:boutique.php');
	}

}
else{ // faire une requête pour récupérer tous les produits du site
	$resultat = $pdo -> query("SELECT * FROM produit");
}
 
// récupérer les résultats de cette requête sous forme exploitable
$infos_produits = $resultat -> fetchAll(PDO::FETCH_ASSOC);

$page = 'Boutique';
require_once('inc/header.inc.php');
?>


<!-- Contenu HTML -->
<h1>Boutique</h1>

<div class="boutique-gauche">
	<ul>
		<li><a href="boutique.php">Tous les produits</a></li>
		<!-- faire une boucle pour afficher la liste de toutes les catégories -->
		<?php foreach ($categorie as $key => $value) : ?>
			<!-- faire en sorte que le menu des catégories soit cliquablent et transmettent le nom de la catégorie en GET -->
			<li><a href="?categorie=<?= $value['categorie'] ?>"><?= $value['categorie'] ?></a></li>
		<?php endforeach; ?>
	</ul>
</div>

<div class="boutique-droite">
	
	<!-- Début vignette produit -->
	<!-- faire une boucle pour afficher la vignette produit pour autant de produits à afficher -->
	<?php foreach ($infos_produits as $key => $value) : ?>
		<?= extract($value) ?>

	<div class="boutique-produit">
		<h3><?= $titre ?><h3>
		<a href="fiche_produit.php?id=<?= $id_produit ?> "><img src="<?= RACINE_SITE ?>photo/<?= $photo ?>" height="100"></a>
		<p style="font-weight: bold; font-size: 20px;"><?= $prix ?>€</p>
		<p style="height: 40px;"><?= substr($description, 0, 30) ?></p>
		<a style="padding: 5px 15px; border: 1px solid red; color: red; border-radius: 4px" href="fiche_produit.php?id=<?= $id_produit ?> ">Voir le produit</a>
	</div>
	
	<?php endforeach; ?>
		
		
	<!-- fin vignette produit -->

</div>


<?php
require('inc/footer.inc.php');
?>

