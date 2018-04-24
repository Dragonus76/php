<?php
if( !empty($_GET) && isset($_GET['action']) && $_GET['action']=='hello'){
	
	echo '<h1>Hello World !</h1>';
	
}


?>

<a href="?action=hello">Afficher Hello World</a>