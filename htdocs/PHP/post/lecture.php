<?php

$fichier = file('liste.txt');
// La fonction file est très pratique, elle fait tout le travail et nous retourne un ARRAY dans lequel chaque élément correspond à une ligne dans notre fichier.

/* 
echo '<pre>';
print_r($fichier);
echo '</pre>'; 
 */

// EXERCICE :

//version for strpos() + substr()
for($i=0; $i<count($fichier); $i ++){
	echo '<h3>Inscrit numéro ' . ($i+1) . '</h3><br>';
	echo 'Pseudo : ' . substr($fichier[$i], 0, strpos($fichier[$i], '-')) . '<br>';
	echo 'Email : ' . substr($fichier[$i], strpos($fichier[$i], '-')+1, 30) . '<hr>';	
}

//version foreach strpos() + substr()
foreach($fichier as $indice => $valeur){
	echo '<h3>Inscrit numéro ' . ($indice+1) . '</h3><br>';
	
	$position = strpos($valeur, '-');
	
	$pseudo = substr($valeur, 0, $position);
	echo 'Pseudo : ' . $pseudo . '<br>';
	
	$email = substr($valeur, $position +3);
	echo 'Email : ' . $email . '<hr>';
}

//version explode et implode
foreach($fichier as $indice => $valeur){
	echo '<h3>Inscrit numéro ' . ($indice+1) . '</h3><br>';
	
	$info = explode(' - ', $valeur);
	$pseudo = $info[0];
	$email = $info [1];
	
	echo 'Pseudo : ' . $pseudo . '<br>';
	echo 'Email : ' . $email . '<hr>';
}
?>

