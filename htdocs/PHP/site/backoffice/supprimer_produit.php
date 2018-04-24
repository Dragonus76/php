<?php
require_once('../inc/init.inc.php');

// vérifier qu'il y a un id dans l'url, que celui-ci n'est pas vide et qu'il s'agit bien d'une valeur numérique

if (isset($_GET['id']) && !empty($_GET['id']) && is_numeric($_GET['id'])) {
	// vérifier dans la BDD si ce produit existe bien (SELECT)
	$resultat = $pdo -> prepare("SELECT * FROM produit WHERE id_produit= :id");
	$resultat -> bindParam(':id', $_GET['id'], PDO::PARAM_INT);
	$resultat -> execute();

	if ($resultat -> rowCount() > 0) { // Cela signifie que le produit dont l'id est récupéré dans l'url existe bien dans notre BDD

		$produit = $resultat -> fetch();

		// si on l'a trouvé dans la BDD, alors on peut faire la requête pour le supprimer
		$resultat = $pdo -> exec("DELETE FROM produit WHERE id_produit = $produit[id_produit]");

		if ($resultat !== FALSE) { // si la requete a fonctionné :
			// supprimer de notre serveur la photo (unlink('chemin absolu du fichier à supprimer')) 
			$chemin_photo_a_supprimer = RACINE_SERVEUR . RACINE_SITE . 'photo/' . $produit['photo'];

			if (file_exists($chemin_photo_a_supprimer) && $produit['photo'] != 'default.jpg') { // si le fichier existe dans notre serveur et ce n'est pas la photo par defaut... on le supprime
				unlink($chemin_photo_a_supprimer);
			}

			header('location:' . RACINE_SITE . 'backoffice/gestion_boutique.php');
		}	
	}
	else{
		header('location:' . RACINE_SITE . 'backoffice/gestion_boutique.php');
	}
}
else{
	header('location:' . RACINE_SITE . 'backoffice/gestion_boutique.php');
}

?>