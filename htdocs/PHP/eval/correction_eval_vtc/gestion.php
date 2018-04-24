<?php
require('inc/init.inc.php');
$contenu ='';
//----------------------------------------------------------------------------------------------------------
function requete($arg)
{
	global $pdo;
	$html = '';
	$htmlat = $pdo->query("$arg");
	$html .= '<table class="table">';
	$html .= '<tr>';
	for($i=0; $i<$htmlat->columnCount(); $i++)
	{
		$colonne = $htmlat->getColumnMeta($i);
		$html .=  '<th>'.$colonne['name'].'</th>';
	}
	$html .= '</tr>';
	while($affichage = $htmlat->fetch(PDO::FETCH_ASSOC))
	{
		$html .= '<tr>';
		foreach($affichage as $indice => $valeur )
		{
			if($valeur){
				$html .= '<td>' . $valeur . '</td>';
			}
			else{
				$html .= '<td style="color: red">---nc---</td>';
			}
		}
		$html .= '</tr>';
	}
	$html .= '</table><br><hr><br>';
	return $html;
} 

require('inc/header.inc.php');

?>

<!-- CONTENU HTML -->
<h1>Gestion et statistiques</h1>

<h4>1. Afficher le nombre de conducteur</h4>
<?= requete('SELECT COUNT(id_conducteur) as "Nombre de conducteur" FROM conducteur')?>

<h4>2. Afficher le nombre de vehicule</h4>
<?= requete('SELECT COUNT(id_vehicule)  as "Nombre de Véhicule" FROM vehicule') ?>

<h4>3. Afficher le nombre d’association</h4>
<?= requete('SELECT COUNT(id_association)  as "Nombre d\'associations" FROM association_vehicule_conducteur')?>

<h4>4. Afficher les vehicules n’ayant pas de conducteur</h4>
<?= requete('SELECT * FROM vehicule WHERE id_vehicule NOT IN (SELECT id_vehicule FROM association_vehicule_conducteur)')?>

<h4>5. Afficher les conducteurs n’ayant pas de vehicule</h4>
<?= requete('SELECT * FROM conducteur WHERE id_conducteur NOT IN (SELECT id_conducteur FROM association_vehicule_conducteur)')?>

<h4>6. Afficher les vehicules conduit par « Philippe Pandre »</h4>
<?= requete('SELECT v.marque, v.modele, c.prenom, c.nom FROM conducteur c, vehicule v, association_vehicule_conducteur a WHERE c.id_conducteur = a.id_conducteur AND v.id_vehicule = a.id_vehicule AND c.prenom = "Philippe" AND c.nom = "Pandre"')?>

<h4>7. Afficher tous les conducteurs (meme ceux qui n'ont pas de correspondance) ainsi que les vehicules</h4>
<?= requete('SELECT v.modele, c.prenom FROM conducteur c LEFT JOIN association_vehicule_conducteur a ON c.id_conducteur = a.id_conducteur	LEFT JOIN vehicule v ON v.id_vehicule = a.id_vehicule')?>

<h4>8. Afficher les conducteurs et tous les vehicules (meme ceux qui n'ont pas de correspondance)</h4>
<?= requete('SELECT v.modele, c.prenom FROM conducteur c	RIGHT JOIN association_vehicule_conducteur a ON c.id_conducteur = a.id_conducteur	RIGHT JOIN vehicule v ON v.id_vehicule = a.id_vehicule')?>

<h4>9.  Afficher tous les conducteurs et tous les vehicules, peut importe les correspondances</h4>
<?= requete('SELECT v.modele, c.prenom FROM conducteur c	LEFT JOIN association_vehicule_conducteur a ON c.id_conducteur = a.id_conducteur	LEFT JOIN vehicule v ON v.id_vehicule = a.id_vehicule 	UNION 	SELECT v.modele, c.prenom FROM conducteur c 	RIGHT JOIN association_vehicule_conducteur a ON c.id_conducteur = a.id_conducteur	RIGHT JOIN vehicule v ON v.id_vehicule = a.id_vehicule')?>



<?php
require('inc/footer.inc.php');
?>