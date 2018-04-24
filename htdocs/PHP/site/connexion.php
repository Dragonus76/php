<?php
require_once('inc/init.inc.php');

// accessibilité : redirection si user déjà connecté
if(userConnect()){
	header('location:profil.php');
}

if($_POST){

	debug($_POST);

	// vérification si le pseudo existe en BDD (donnée sensible)
	$resultat = $pdo -> prepare("SELECT * FROM membre WHERE pseudo = :pseudo");
	$resultat -> bindParam(':pseudo', $_POST['pseudo'], PDO::PARAM_STR);
	$resultat -> execute();

	// On aurait pu faire comme ceci :
	// $resultat = $pdo -> prepare("SELECT * FROM membre WHERE pseudo = :pseudo");
	// $resultat -> execute(array('pseudo' => $_POST['pseudo']));

	
	// si on a trouvé au moins un resultat, tout va bien, sinon cela signifie : erreur de pseudo
	if($resultat -> rowCount() == 0){ // == car c'est une comparaison!
		$msg .= '<div class="erreur">Le pseudo est erroné</div>';
	}
	// si on a trouvé un résultat, on récupère les infos de user dans un array
	else{
		$membre = $resultat -> fetch(); // par defaut cela fait un PDO::FETCH_ASSOC car on l'a configuré dans le fichier init!
		debug($membre);
	

	// ensuite si le mdp de user en BDD est === à mdp posté et crypté, alors on peut connecter user...
		if($membre['mdp'] === md5($_POST['mdp'])){
		// $membre['mdp'] correspond au mot de passe dans la BDD, il est stocké crypté!
		// $_POST['mdp'] correspond au mot de passe que l'user vient d'entrer dans le fichier de connexion. On le crypte avec md5.
		// Si les deux mdp crypté sont identiques, on peut continuer!

		// connecter user signifie prendre toutes les infos et les enregistrer dans le fichier de session grace à $_SESSION
			foreach($membre as $indice => $valeur){
				if($indice != 'mdp'){
					$_SESSION['membre'][$indice] = $valeur;
				}
			}
			// Cette boucle fait ceci :
			// $_SESSION['membre']['pseudo'] = $membre['pseudo'];
			// $_SESSION['membre']['prenom'] = $membre['prenom'];
			// ...
			debug($_SESSION);

			header('location:profil.php');

		}
		// sinon cela signifie que le mdp n'est pas correct
		else{
			$msg .= '<div class="erreur">Le mot de passe est erroné</div>';
		}
	}
	

}


$page = 'Connexion';
$meta_description ='Bienvenue sur la page de connexion de notre site!';

require_once('inc/header.inc.php');
?>

<!-- Contenu HTML -->
<h1>Connexion</h1>

<form method="post" action="">

	<?= $msg ?>

	<label>Pseudo</label>
	<input type="text" name="pseudo">

	<label>Mot de passe</label>
	<input type="password" name="mdp">

	<input type="submit" value="Connexion"></form>

</form>




<?php
require('inc/footer.inc.php');
?>