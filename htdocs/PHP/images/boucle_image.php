<?php
// Afficher l'image 1
echo '<img src="1.jpg" alt="arbre enneigé" style="margin: 5px;">';
		
// Afficher 5 fois l'image 1	
$i = 0;
while($i < 5){
	echo '<img src="1.jpg" alt="arbre enneigé" style="margin: 5px">';
	$i ++;
}
echo '<br>';

// Afficher les 5 images
$j = 1;
while($j < 6){
	echo '<img src="' . $j . '.jpg" alt="" style="margin: 5px; height: 400px;">';
	$j ++;
}
echo '<br>';
?>
