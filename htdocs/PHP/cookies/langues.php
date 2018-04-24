<h1>Cookies - Langues</h1>

<ul>
	<li><a href="?lang=fr">France</a></li>
	<li><a href="?lang=it">Italie</a></li>
	<li><a href="?lang=es">Espagne</a></li>
	<li><a href="?lang=en">Angleterre</a></li>
</ul>
<hr>

<?php

echo '<pre>';
print_r($_GET);
echo '</pre>';

if( isset($_GET['lang']) ){// Si un choix de langue existe dans l'url, cela signifie que l'utilisateur vient de sélectionner une langue (probablement sa première visite).
	$langue = $_GET['lang'];
}
elseif( isset($_COOKIE['lang']) ){// S'il existe un cookie avec la langue précisée cela signifie que l'utilisateur est déjà venu et qu'il avait déjà choisi sa langue.
	$langue = $_COOKIE['lang'];
}
else{// Cela signifie que c'est probablement la première fois que l'utilisateur vient, et que la langue par défaut (français) lui convient.
	$langue = 'fr';
	
}

// Quoi qu'il arrive, on sort de cette triple condition avec une valeur dans $langue. Soit la valeur choisie à l'instant par l'utilisateur, soit la valeur enregistrée précédement, soit la valeur par défaut.
// On va donc maintenant enregistrer cette valeur pendant 1 an.

// echo time(); renvoi le timestamp actuel
$annee = 365 * 24 * 60 * 60; //nombre de secondes dans une année



setCookie('lang', $langue, time()+$annee); // Cette fonction permet de créer un cookie. Elle attend 3 arguments :
	//1- le nom du cookie
	//2- la valeur du cookie
	//3- date d'expiration (timestamp)

echo '<pre>';
print_r($_COOKIE);
echo '</pre>';

switch($langue){
	
	case 'fr' :
		echo 'Bonjour, vous visitez actuellement le site en français';
	break;
	
	case 'es' :
		echo 'Hola, esta visitando actualmente el sitio en español';
	break;
	
	case 'it' :
		echo 'Ciao, sta visitando attualmente il sito in italiano';
	break;
	
	case 'en' :
		echo 'Hello, you are currently visiting this website in english';
	break;
	
	default : 
		echo 'Veuillez choisir une langue disponible';
	break;
	
}






























?>