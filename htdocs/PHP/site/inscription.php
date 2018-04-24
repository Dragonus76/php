<?php
require_once('inc/init.inc.php');

// accessibilité : redirection si user déjà connecté
if(userConnect()){
	header('location:profil.php');
}

if($_POST){

	debug($_POST);

	// vérification du pseudo :
	if(!empty($_POST['pseudo'])){
		// Ok, le pseudo est rempli, on va vérifier le nombre et la nature des caratères
		$verif_pseudo = preg_match('#^[a-zA-Z0-9-._]{3,20}$#', $_POST['pseudo']); // la fonction preg_match() nous permet de définir les caractères autorisés dans une CC. Elle attend deux arguments :
		// 1 : REGEX (ou expression régulière)
		// 2 : la CC
		// valeurs de retour : 
			// succès : TRUE
			// échec : FALSE
		if(!$verif_pseudo){ // si les caractères utilisés dans le pseudo posent problèmes à preg_match qui nous retourne FALSE
			$msg .= '<div class="erreur">Votre pseudo doit comporter de 3 à 20 caractère (de A à Z, de 0 à 9, et ".", "-", "_")</div>';
		}

	}
	else{
		$msg .= '<div class="erreur">Veuillez renseigner un pseudo</div>';
	}


	// vérification du mdp :
	if(!empty($_POST['mdp'])){
		$verif_mdp = preg_match('#^(?=.*[A-Z])(?=.*[a-z])(?=.*\d)(?=.*[-+!*\'\?$@%_])([-+!*\?$\'@%_\w]{8,15})$#', $_POST['mdp']);
		// notre mdp doit contenir :
			// -> 8 caractères min et 15 max.
			// -> 1 MAJ, 1 min, 1 chiffre
			// -> 1 caratère spécial : -+!*\'\?$@%_
		if(!$verif_mdp){
			$msg .= '<div class="erreur">Votre mot de passe doit comporter de 8 à 15 caractère (dont au moins une MAJ, un chiffre et un caratère spécial)</div>';
		}

	}
	else{
		$msg .= '<div class="erreur">Veuillez renseigner un mot de passe</div>';
	}


	// vérification de l'email :

	if(!empty($_POST['email'])){
		$verif_email = filter_var($_POST['email'], FILTER_VALIDATE_EMAIL);
		// filter_var() nous permet de vérifier si une CC est un email ou une url par exemple. Elle attend deux arguments :
			// 1 : la CC
			// 2 : la méthode de vérification (le type de contenu à vérifier)
			// valeurs de retour : 
				// succès : TRUE
				// échec : FALSE
		$dom_interdit = array(
			'yopmail.com',
			'mailinator.com',
			'mail.com'
		);

		$dom_email = explode('@', $_POST['email']);
		// exemple = yakine.hamida@evogue.fr
		// $dom_email[0] = 'yakine.hamida'
		// $dom_email[1] = 'evogue.fr'

		if(!$verif_email || in_array($dom_email[1], $dom_interdit)){
			$msg .= '<div class="erreur">Veuillez renseigner un email valide</div>';
		}

	}
	else{
		$msg .= '<div class="erreur">Veuillez renseigner un email</div>';
	}


	// Tout est OK, on peut enregistrer l'utilisateur
	if(empty($msg)){
		// Le pseudo est-il disponible?
		$resultat = $pdo -> prepare("SELECT * FROM membre WHERE pseudo = :pseudo");
		$resultat -> bindParam(':pseudo', $_POST['pseudo'], PDO::PARAM_STR);
		$resultat -> execute();

		if($resultat -> rowCount() > 0){// Cela signifie que nous avons trouvé un enregistrement en BDD avec ce pseudo, il n'est donc pas dispo...
			$msg .= '<div class="erreur">Le pseudo ' . $_POST['pseudo'] . ' n\'est malheureusement pas disponible, veuillez en choisir un autre.</div>';

			// On pourrait lui proposer deux ou trois variantes de son pseudo ci celui-ci n'était pas dispo.

			// ATTENTION : en théorie nous devrions aussi vérifier la disponibilité de l'email... et éventuellement lui proposer "mot de passe oublié ?"
		}
		else{
			// INSERT + crypter le mot de passe
			$resultat = $pdo -> prepare("INSERT INTO membre (pseudo, mdp, nom, prenom, email, civilite, ville, code_postal, adresse, statut) VALUES(:pseudo, :mdp, :nom, :prenom, :email, :civilite, :ville, :code_postal, :adresse, 0) ");

			$mdp_crypte = md5($_POST['mdp']); // protocole de cryptage le moins élevé
			// on peut le renforcer par un salage : CC secrète qu'on crypte une première fois, puis qu'on concatène à nos mdp lors de la phase de cryptage.
			//$salage = 'ceciestunsalt';
			//$salt_crypt = md5($salage);
			//$mdp_crypte = md5($_POST['mdp'] . $salt_crypt);
		


			// PDO::PARAM_STR
			$resultat -> bindParam(':pseudo', $_POST['pseudo'], PDO::PARAM_STR);
			$resultat -> bindParam(':mdp', $mdp_crypte, PDO::PARAM_STR);
			$resultat -> bindParam(':nom', $_POST['nom'], PDO::PARAM_STR);
			$resultat -> bindParam(':prenom', $_POST['prenom'], PDO::PARAM_STR);
			$resultat -> bindParam(':email', $_POST['email'], PDO::PARAM_STR);
			$resultat -> bindParam(':civilite', $_POST['civilite'], PDO::PARAM_STR);
			$resultat -> bindParam(':ville', $_POST['ville'], PDO::PARAM_STR);
			$resultat -> bindParam(':adresse', $_POST['adresse'], PDO::PARAM_STR);
			

			// PDO::PARAM_INT
			$resultat -> bindParam(':code_postal', $_POST['code_postal'], PDO::PARAM_INT);

			if($resultat -> execute()){ // si la requête se passe bien on redirige
				header('location:connexion.php');

			}
		}
	}

} // Fermeture du if($_POST)

// Traitement pour récupérer les données saisies et les remttres dans le formulaire

/*
if(isset($_POST['pseudo'])){
	$pseudo = $_POST['pseudo'];
}
else{
	$pseudo ='';
}*/


// Voici une façon plus simple de faire le if/else ci-dessus :

$pseudo = 		(isset($_POST['pseudo'])) ? $_POST['pseudo'] : '';
$prenom = 		(isset($_POST['prenom'])) ? $_POST['prenom'] : '';
$nom = 			(isset($_POST['nom'])) ? $_POST['nom'] : '';
$adresse =		(isset($_POST['adresse'])) ? $_POST['adresse'] : '';
$civilite =		(isset($_POST['civilite'])) ? $_POST['civilite'] : '';
$ville = 		(isset($_POST['ville'])) ? $_POST['ville'] : '';
$code_postal = 	(isset($_POST['code_postal'])) ? $_POST['code_postal'] : '';
$email = 		(isset($_POST['email'])) ? $_POST['email'] : '';


$page = 'Inscription';
$meta_description ='Bienvenue sur la page d\inscription de notre site!';


require_once('inc/header.inc.php');
?>

<!-- Contenu HTML -->
<h1>Inscription</h1>

<form method="post" action="">

<?= $msg ?>

<label>Pseudo</label>
<input type="text" name="pseudo" value="<?= $pseudo ?>">

<label>Mot de passe</label>
<input type="password" name="mdp">

<label>Nom</label>
<input type="text" name="nom" value="<?= $nom ?>">

<label>Prénom</label>
<input type="text" name="prenom" value="<?= $prenom ?>">

<label>Email</label>
<input type="text" name="email" value="<?= $email ?>">

<label>Civilité</label>
<select name="civilite">
	<option <?= ($civilite == 'm') ? 'selected' : '' ?> value="m">Homme</option>
	<option <?= ($civilite == 'f') ? 'selected' : '' ?> value="f">Femme</option>
</select>

<label>Ville</label>
<input type="text" name="ville" value="<?= $ville ?>">

<label>Code postal</label>
<input type="text" name="code_postal" value="<?= $code_postal ?>">

<label>Adresse</label>
<input type="text" name="adresse" value="<?= $adresse ?>">

<input type="submit" value="Inscription">








</form>

<?php
require('inc/footer.inc.php');
?>