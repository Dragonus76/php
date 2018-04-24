<?php
require_once('../inc/init.inc.php');

// accessibilité : si user non admin ===> redirection
if (!userAdmin()) { // Si la fonction userAdmin() nous retourne false, cela signifie que l'user n'est pas admin
	header('location:' . RACINE_SITE . 'index.php'); // Mieux vaut mettre RACINE_SITE car ils ne sont pas dans le même dossier
}

// Traitements pour enregistrer un produit
if ($_POST) {
	debug($_POST);
	debug($_FILES); // permet d'afficher toutes les infos de la photo qui est type="file"

	if (!empty($_FILES['photo']['name'])) { // = si une photo est uploadée
		// 1 : on va modifier le nom de la photo pour éviter les doublons potentiels (exemple, deux t-shirts ayant une photo tshirt.jpg)
		$nom_photo = $_POST['reference'] . '_' . time() . '_' . rand(1, 999) . '_' . $_FILES['photo']['name'];
		// exemple : tshirts.jpg => DSFGD-54_1500000000_458_tshirt.jpg

		// 2 : on va créer une variable contenant le chemin absolu et définitif de la photo. Le chemin d'un fichier doit commencer par la racine du serveur et s'arrête à l'extension.
		$chemin_photo = RACINE_SERVEUR . RACINE_SITE . 'photo/' . $nom_photo;
		// exemple : C://xampp/htdocs/PHP/site/photo/DSFGD-54_1500000000_458_tshirt.jpg
		
		// 3 : on vérifie l'intégrité du fichier uploadé (poids et extension)
		if ($_FILES['photo']['size'] > 2000000) {
			$msg .= '<div class="erreur">Veuillez sélectionner un fichier de 2Mo maximum<div>';
		}

		$extension = array('image/jpeg', 'image/png', 'image/gif');
		if (!in_array($_FILES['photo']['type'], $extension)) {
			$msg .= '<div class="erreur">Veuillez sélectionner une image de type JPG, JPEG, PNG ou GIF<div>';
		}

		// 4 : si tout est ok et que le produit est bien enregistré en BDD, il nous reste à copier l'image dans notre dossier photo/


	}
	elseif (isset($_POST['photo_actuelle'])) {
		// Si je suis en train de modifier un produit alors photo_actuelle existe et je prends sa valeur pour la mettre dans nom_photo, afin qu'elle soit enregistrée telle quelle dans la BDD.
		$nom_photo = $_POST['photo_actuelle'];
	}
	else{
		$nom_photo ='default.jpg';
	}

	// Vérifications sur tous les autres champs : nbr de caractères, preg_match, valeur numérique (prix et stock), non vide...

	// Si tout est ok dans notre formulaire, on peut enregistrer le produit en BDD et la photo dans son emplacement définitif
	if (empty($msg)) {

		// Si on est dans la phase de modification :
		if (!empty($_POST['id_produit'])) { // Si un id_produit est renseigné on est en phase modification
			$resultat = $pdo -> prepare("REPLACE INTO produit (id_produit, reference, categorie, titre, description, couleur, taille, public, photo, prix, stock) VALUES (:id_produit, :reference, :categorie, :titre, :description, :couleur, :taille, :public, :photo, :prix, :stock) ");

			$resultat -> bindParam(':id_produit', $_POST['id_produit'], PDO::PARAM_INT);
		}
		else{ // Sinon c'est qu'on est en phase création : on enregistre le produit en BDD
			$resultat = $pdo -> prepare("INSERT INTO produit (reference, categorie, titre, description, couleur, taille, public, photo, prix, stock) VALUES (:reference, :categorie, :titre, :description, :couleur, :taille, :public, :photo, :prix, :stock) ");
		}

		// STR
		$resultat -> bindParam(':reference', $_POST['reference'], PDO::PARAM_STR);
		$resultat -> bindParam(':categorie', $_POST['categorie'], PDO::PARAM_STR);
		$resultat -> bindParam(':titre', $_POST['titre'], PDO::PARAM_STR);
		$resultat -> bindParam(':description', $_POST['description'], PDO::PARAM_STR);
		$resultat -> bindParam(':couleur', $_POST['couleur'], PDO::PARAM_STR);
		$resultat -> bindParam(':taille', $_POST['taille'], PDO::PARAM_STR);
		$resultat -> bindParam(':public', $_POST['public'], PDO::PARAM_STR);
		$resultat -> bindParam(':photo', $nom_photo, PDO::PARAM_STR);
		$resultat -> bindParam(':prix', $_POST['prix'], PDO::PARAM_STR);

		// INT
		$resultat -> bindParam(':stock', $_POST['stock'], PDO::PARAM_INT);

		if($resultat -> execute()){ // Si la requête s'est bien déroulée
			// 1 : on enregistre le fichier photo dans son emplacement définitif
			if (!empty($_FILES['photo']['name'])) {
				copy($_FILES['photo']['tmp_name'], $chemin_photo);
				// copy() permet de copier/coller un fichier. En l'occurence ici, on copie le fichier photo de son emplacement temporaire vers son emplacement définitif
			}

			// 2 : on redirige vers la page gestion_boutique
			header('location:gestion_boutique.php'); // Pas besoin de RACINE_SITE car ils sont dans le même dossier

		}

	}
}

// Traitements pour récupérer les infos du produit à modifier
if (isset($_GET['id']) && !empty($_GET['id']) && is_numeric($_GET['id'])){ // S'il y a un id_produit dans l'url, non vide et de type numérique...
	$resultat = $pdo -> prepare("SELECT * FROM produit WHERE id_produit = :id");
	$resultat -> bindParam(':id', $_GET['id'], PDO::PARAM_INT);
	$resultat -> execute();

	if($resultat -> rowCount() > 0){
		$produit_actuel = $resultat -> fetch();

		debug($produit_actuel);
	}
}

// Si le produit actuel existe alors on crée des variables pour stocker les infos de ce produit. S'il n'existe pas, on crée tout de même les variables, vides, afin de les afficher quoi qu'il arrive dans les attributs value de notre formulaire.
// On définit une variable $action qui va stocker soit 'modifier' soit 'ajouter' afin de rendre dynamique le h1 et le bouton du formulaire.

$reference = (isset($produit_actuel)) ? $produit_actuel['reference'] : '';
$categorie = (isset($produit_actuel)) ? $produit_actuel['categorie'] : '';
$titre = (isset($produit_actuel)) ? $produit_actuel['titre'] : '';
$description = (isset($produit_actuel)) ? $produit_actuel['description'] : '';
$couleur = (isset($produit_actuel)) ? $produit_actuel['couleur'] : '';
$taille = (isset($produit_actuel)) ? $produit_actuel['taille'] : '';
$public = (isset($produit_actuel)) ? $produit_actuel['public'] : '';
$photo = (isset($produit_actuel)) ? $produit_actuel['photo'] : '';
$prix = (isset($produit_actuel)) ? $produit_actuel['prix'] : '';
$stock = (isset($produit_actuel)) ? $produit_actuel['stock'] : '';

$id_produit = (isset($produit_actuel)) ? $produit_actuel['id_produit'] : '';
$action = (isset($produit_actuel)) ? 'Modifier' : 'Ajouter';



require_once('../inc/header.inc.php');
?>

<!-- Contenu HTML -->
<h1><?= $action ?> un produit</h1>

<form method="post" action="" enctype="multipart/form-data"> 
	<!-- l'attribut enctype="multipart/form-data nous permet de récupérer les fichiers uploadés sous forme de data -->
	<?= $msg ?>

	<input type="hidden" name="id_produit" value="<?= $id_produit ?>">
	<!-- Le champs ci-dessus permet de transmettre à notre requête REPLACE l'id du produit en cours de modification -->

	<label>Référence</label>
	<input type="text" name="reference" value="<?= $reference ?>">

	<label>Catégorie</label>
	<input type="text" name="categorie" value="<?= $categorie ?>">

	<label>Titre</label>
	<input type="text" name="titre" value="<?= $titre ?>">

	<label>Description</label>
	<textarea name="description"><?= $description ?></textarea>

	<label>Couleur</label>
	<input type="text" name="couleur" value="<?= $couleur ?>">

	<label>Taille</label>
	<input type="text" name="taille" value="<?= $taille ?>">

	<label>Public</label>
	<select name="public" value="<?= $public ?>">
		<option <?php if($public == 'm') {echo 'selected';} ?> value="m">Homme</option>
		<option <?php if($public == 'f') {echo 'selected';} ?> value="f">Femme</option>
		<option <?php if($public == 'mixte') {echo 'selected';} ?> value="mixte">Mixte</option>
	</select>

	<?php
	if (isset($produit_actuel)) { // si nous sommes en train de modifier un produit
		echo '<input type="hidden" name="photo_actuelle" value="' . $photo . '">'; 
		echo '<img src="' . RACINE_SITE . 'photo/' . $photo . '" width="75">';
	}
	?>

	<label>Photo</label>
	<input type="file" name="photo">

	<label>Prix</label>
	<input type="text" name="prix" value="<?= $prix ?>">

	<label>Stock</label>
	<input type="text" name="stock" value="<?= $stock ?>">

	<input type="submit" value=<?= $action ?>>

</form>

<?php
require_once('../inc/footer.inc.php');
?>