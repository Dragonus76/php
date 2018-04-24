<?php

echo '<pre>';
print_r($_POST);
echo '</pre>'; 


if($_POST){
	
	if( is_numeric($_POST['nombre1']) && is_numeric($_POST['nombre2']) ){
		
		switch($_POST['operateur']){
			case 'addition' :
				$resultat = $_POST['nombre1'] + $_POST['nombre2'];
			break;
			case 'soustraction' :
				$resultat = $_POST['nombre1'] - $_POST['nombre2'];
			break;
			case 'multiplication' :
				$resultat = $_POST['nombre1'] * $_POST['nombre2'];
			break;
			case 'division' :
				$resultat = $_POST['nombre1'] / $_POST['nombre2'];
			break;
			
			default: 
				echo 'Veuillez refaire le calcul';
			break;
		}
	}
	
}

echo 'Le résultat est : ' . $resultat;


?>