<?php

if($_POST){ // On vérifie si le formulaire est bien activé
	/* echo '<pre>';
	print_r($_POST);
	echo '</pre>'; */
	
	if(!empty($_POST['pseudo']) && !empty($_POST['email'])){
			echo 'Pseudo : ' . $_POST['pseudo']. '<br>';
			echo 'Email : ' . $_POST['email']. '<br>';
			
		// Traitements pour enregistrer ces données dans un fichier texte.
		$f = fopen('liste.txt', 'a'); //fopen() est une fonction qui nous permet d'ouvrir un fichier. Avec le mode 'a', si le fichier n'existe pas, elle le crée à la volée.
		// $f va représenter notre fichier durant le script.
		
		fwrite($f, $_POST['pseudo'] . ' - ' . $_POST['email'] . "\r\n");  // fwrite() est une fonction qui nous permet d'écrire des informations dans un fichier. La fonction attend deux arguments :
			// 1- le fichier ($f)
			// 2- le contenu à écrire
			
		fclose($f); //Cela ferme le fichier et libère un peu de ressource
				
		}
		else{
			echo '<p style="background: red; padding: 5px; color: white;">Attention, veuillez renseigner tous les champs. <a href="formulaire3.php">Lien vers le formulaire</a></p>';
		}
}

?>