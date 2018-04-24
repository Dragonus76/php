<?php 

echo '<pre>'; 
print_r($_GET);
echo '</pre>'; 

$message = 'Bonjour veuillez sélectionner votre langue :)';

if(!empty($_GET) && isset($_GET['lang']) ){ // On vérifie s'il y a des paramètres dans l'URL, et notamment si le parametre LANG est définie... Sinon pas d'action
	
	switch($_GET['lang']){ // Selon la valeur du paramètre LANG :
		
		case 'fr' :
			$message = 'Vous êtes français !';
		break;
		
		case 'it' :
			$message = 'Vous êtes italiens !';
		break;
		
		case 'es' :
			$message = 'Vous êtes espagnol !';
		break;
		
		case 'en' :
			$message = 'Vous êtes anglais !';
		break;
		
		default : 
			$message = 'Veuillez sélectionner une langue disponible';
		break;
	}	
}
?>
<h1>Message</h1>
<ul>
	<li><a href="?lang=fr">France</a></li>
	<li><a href="?lang=it">Italie</a></li>
	<li><a href="?lang=es">Espagne</a></li>
	<li><a href="?lang=en">Angleterre</a></li>
</ul>
<hr/>
<?= $message ?>



