<?php
$pdo = new PDO('mysql:host=localhost;dbname=repertoire', 'root', '', array(
	PDO::ATTR_ERRMODE => PDO::ERRMODE_WARNING
));

$resultat = $pdo -> query("SELECT * FROM annuaire");
$infos = $resultat -> fetchAll(PDO::FETCH_ASSOC);
 

echo '<table border="1">'; 
echo '<tr>'; 

for($i = 0; $i < $resultat -> columnCount(); $i++ ){ 
	$champs = $resultat -> getColumnMeta($i);
	echo '<th>' . $champs['name'] . '</th>'; 
	
}
echo '</tr>'; 

foreach($infos as $value){
	echo '<tr>'; 
	foreach($value as $value2){
		echo '<td>' . $value2 . '</td>'; 
	}
	echo '</tr>'; 	
}
echo '</table><br>'; 

$resultat = $pdo -> query("SELECT COUNT(sexe) as 'nbr_homme' FROM annuaire WHERE sexe = 'm'");

$homme = $resultat -> fetch(PDO::FETCH_ASSOC);


echo 'le nombre d\'hommes est ' . $homme[nbr_homme] . '<br>';

$resultat = $pdo -> query("SELECT COUNT(sexe) as 'nbr_femme' FROM annuaire WHERE sexe = 'f'");

$femme = $resultat -> fetch(PDO::FETCH_ASSOC);


echo 'le nombre de femmes est ' . $femme[nbr_femme] . '<br>';


?>