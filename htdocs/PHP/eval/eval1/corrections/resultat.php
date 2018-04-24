<?php

echo '<pre>'; 
print_r($_POST);
echo '</pre>'; 

if($_POST){
	if(is_numeric($_POST['n1']) && is_numeric($_POST['n2']) ){
		switch($_POST['operateur']){
			case 'addition' : 
				$resultat = $_POST['n1'] + $_POST['n2'];
			break;
			
			case 'soustraction' : 
				$resultat = $_POST['n1'] - $_POST['n2'];
			break;
			
			case 'multiplication' : 
				$resultat = $_POST['n1'] * $_POST['n2'];
			break;
			
			case 'division' : 
				if($_POST['n2'] === '0'){
					$resultat = 'Attention, division par 0 impossible';
				}
				else{
					$resultat = $_POST['n1'] / $_POST['n2'];
				}
			break;
			
			default : 
				$resultat = 'Aucun résultat, veuillez relancer un nouveau calcul';
			break;
		}	
	}
}
?>

Voici le résultat :  <?= $resultat ?> <br/>
Effectuer un autre calcul : <a href="calculatrice.php">Accès à la calculatrice</a>

