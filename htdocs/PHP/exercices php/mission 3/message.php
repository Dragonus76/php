<?php


echo '<pre>';
print_r($_GET)
;echo '</pre>';


if($_GET && isset($_GET['pays'])){
	//1- On vérifie s'il y a des paramètres dans l'urldecode
	//2- On vérifie si le paramètre pays est défini

	switch($_GET['pays']){
		case 'français' :
			$msg = 'Vous êtes français';
		break;
		case 'italien' :
			$msg = 'Vous êtes italien';
		break;
		case 'espagnol' :
			$msg = 'Vous êtes espagnol';
		break;
		case 'anglais' :
			$msg = 'Vous êtes anglais';
		break;
		
		default : 
			echo 'Veuillez séléctionner une langue disponible';
		break;
	}	
	
}

?>

<h1>Mission 3</h1>

<ul>
	<li><a href="message.php?pays=français">France</a></li>
	<li><a href="message.php?pays=italien">Italie</a></li>
	<li><a href="message.php?pays=espagnol">Espagne</a></li>
	<li><a href="message.php?pays=anglais">Angleterre</a></li>
</ul>

<?= $msg ?>