<?php
require_once('../inc/init.inc.php');

// accessibilité : si user non admin ===> redirection
if (!userAdmin()) { // Si la fonction userAdmin() nous retourne false, cela signifie que l'user n'est pas admin
	header('location:' . RACINE_SITE . 'index.php');
}


// Affichage d'un tableau des produits
$resultat = $pdo -> query("SELECT * FROM produit");

$produit = $resultat -> fetchAll(PDO::FETCH_ASSOC);

$contenu .= '<table border="1">';

	$contenu .= '<tr>';

	for($i=0; $i<$resultat -> columnCount(); $i++){
		$champs = $resultat -> getColumnMeta($i);
		$contenu .= '<th>' . $champs['name'] . '</th>';
	}

	$contenu .= '<th colspan="2">Actions</th>';
	$contenu .= '</tr>';

	foreach ($produit as $value) {
		$contenu .= '<tr>';
	
		foreach ($value as $key2 => $value2) {

			if ($key2 == 'photo') {
				$contenu .= '<td><img height="100" src="' . RACINE_SITE . 'photo/' . $value['photo'] . '"></td>';
			}
			else{$contenu .= '<td>' . $value2 . '</td>';
			}
		}

		$contenu .= '<td><a href="formulaire_produit.php?id=' . $value['id_produit'] . '"><img src="../img/edit.png"></td>';
		$contenu .= '<td><a href="supprimer_produit.php?id=' . $value['id_produit'] . '"><img src="../img/delete.png"></td>';

		$contenu .= '</tr>';
	}

$contenu .= '</table>';



require_once('../inc/header.inc.php');
?>

<!-- Contenu HTML -->
<h1>Gestion de la boutique</h1>

<a style="padding: 5px; border: 2px solid #32c8de; color: #32c8de; border-radius: 3px; display: block; width: 150px; margin-bottom: 20px; text-align: center; font-weight: bold;" href="formulaire_produit.php">Ajouter un produit</a>

<?= $contenu ?>

<?php
require_once('../inc/footer.inc.php');
?>