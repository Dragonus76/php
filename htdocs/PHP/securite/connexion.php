<?php
/*
Un injection SQL permet de détourner le comportement initialement prévu par la requête. 

----------
Exemple 1 : 
	- pseudo : juju'#
	- mdp : 

	Requête : SELECT * FROM membre WHERE pseudo = 'juju'#' AND mdp = ''
	
	Explications : Le hashtag permet de mettre la suite de la requête en commentaire. On cherche donc un membre dont le speudo c'est 'juju' et peu importe la suite. 
	
-----------
Exemple 2 : 
	- pseudo : 
	- mdp : ' OR id_membre = '2

	Requête : SELECT * FROM membre WHERE pseudo = '' AND mdp = '' OR id_membre = '2'

	Explications : On demande le membre ayant un pseudo vide, et un mot de passe vide (ce membre n'existe pas) OU ALORS le membre dont l'id est le 2 ! 
	
----------
exemple 3 : 
	pseudo : 
	mdp : ' OR 1 = '1
	
	Requête :  SELECT * FROM membre WHERE pseudo = '' AND mdp = '' OR 1 = '1'

	Explications : On demande le membre ayant un pseudo vide et un mdp vide (membre n'existant pas) ou alors 1 = '1'. SQL ne comprend, et nous retourne le premier membre. 


-----------
exemple 4 (injection de code)
	pseudo : <p style="color:red">test</p>
	mdp : 
	
	Explications : On a injecté du code, qui a été interprêté comme étant du code. Nous aurions pu injecter un traitement en Javascript et celui-ci aurait fonctionné. 
	

*/
session_start();
$pdo = new PDO('mysql:host=localhost;dbname=securite', 'root', '');

if($_POST){ // est-ce que le formulaire a été activé

	echo '<pre>'; 
	print_r($_POST);
	echo '</pre>'; 
	
	echo 'Pseudo : ' . $_POST['pseudo'] . '<br/>'; 
	echo 'Mot de passe : ' . $_POST['mdp'] . '<hr/>'; 
	
	
	echo '<h3>Après nettoyage :</h3>';
	
	// $_POST['pseudo'] = htmlentities(addslashes($_POST['pseudo']));
	// $_POST['mdp'] = htmlentities(addslashes($_POST['mdp']));
	
	//Ou via un foreach : 
	foreach($_POST as $indice => $valeur){
		$_POST[$indice] = htmlentities(addslashes($valeur));
	}
	
	echo 'Pseudo : ' . $_POST['pseudo'] . '<br/>'; 
	echo 'Mot de passe : ' . $_POST['mdp'] . '<hr/>'; 
	
	
	$req = "SELECT * FROM membre WHERE pseudo = '$_POST[pseudo]' AND mdp = '$_POST[mdp]'";
	$resultat = $pdo -> query($req);
	echo 'Requête  : ' . $req . '<hr/>';
	
	
	if($resultat -> rowCount() > 0){
		// On entre dans ce IF, si on a trouvé un membre correspondant au pseudo et au MDP, et donc on peut le connecter. 
		
		$membre = $resultat -> fetch(PDO::FETCH_ASSOC);
		// $membre est un array contenant toutes les infos du membre qui est en train de se connecter. 
		
		echo '<div style="background:green; padding: 5px; color: white" >';
		echo '<p>Félicitations, vous êtes connecté</p>';
		echo '<ul>';
		echo '	<li>Prénom : ' . $membre['prenom'] . '</li>';
		echo '	<li>Nom : ' . $membre['nom'] . '</li>';
		echo '	<li>Email : ' . $membre['email'] . '</li>';
		echo '	<li>MDP : ' . $membre['mdp'] . '</li>';
		echo '</ul>';
		echo '</div>';
	}
	else{
		echo '<p style="background:red; color: white; padding: 5px" >Erreur d\'identifiant !</p>';	
	}
}

?>
<html>
	<h1>Connexion</h1>
	<form method="post" action="">
		<label>Pseudo </label><br/>
		<input type="text" name="pseudo" /><br/><br/>
		
		<label>Mot de passe</label><br/>
		<input type="text" name="mdp" /><br/><br/>
		
		<input type="submit" value="Connexion" />
	
	</form>
</html>