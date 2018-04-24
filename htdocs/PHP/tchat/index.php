<?php
session_start(); // Création du fichier s'il n'existe pas ou ouverture de session s'il existe
$pdo = new PDO('mysql:host=localhost;dbname=tchat', 'root', ''); // Connexion à la BDD

echo'<pre>';
print_r($_POST);
print_r($_FILES);//pour afficher un array multidimentionnel de l'avatar
echo'</pre>';

$msg_inscription = "";

// Traitements pour inscription :
if(isset($_POST['inscription'])){ // Si le bouton inscription a été activé, on cible spécifiquement ce formulaire
	
	if(empty($_POST['pseudo']) || empty($_POST['password']) || empty($_POST['email'])){
		$msg_inscription .= '<div class="erreur"> Veuillez renseigner un pseudo, un mot de passe et un email</div>';
	}
	
	if(!empty($_FILES['avatar']['name'])){
	copy($_FILES['avatar']['tmp_name'], 'image/' . $_FILES['avatar']['name']);
	// copy permet de copier/coller un fichier depuis un emplacement d'origine et vers un emplacement de destination.
	}
	
	if(empty($msg_inscription)){
		$resultat = $pdo -> prepare("INSERT INTO membre(pseudo, mdp, avatar, email) VALUES(:pseudo, :mdp, :avatar, :email)");
		
		$resultat -> bindParam(':pseudo', $_POST['pseudo'], PDO::PARAM_STR);
		$resultat -> bindParam(':mdp', $_POST['password'], PDO::PARAM_STR);
		$resultat -> bindParam(':avatar', $_FILES['avatar']['name'], PDO::PARAM_STR);
		$resultat -> bindParam(':email', $_POST['email'], PDO::PARAM_STR);
		
		if($resultat -> execute()){
			$msg_inscription .= '<div style="color: white; background: green; padding: 5px">Félicitations, vous êtes inscrit.</div>';
		}
		
	}
}



// Traitements pour connexion :
$msg_connexion= "";

if(isset($_POST['connexion'])){ // Si le bouton connexion a été activé, on cible spécifiquement ce formulaire

		$resultat = $pdo -> prepare("SELECT * FROM membre WHERE pseudo = :pseudo AND mdp = :mdp");
		
		$resultat -> bindParam(':pseudo', $_POST['pseudo'], PDO::PARAM_STR);
		$resultat -> bindParam(':mdp', $_POST['password'], PDO::PARAM_STR);
		
		$resultat -> execute();
		
		if($resultat -> rowCount()>0){
			// ok le membre existe bien, on peut le connecter
			$membre = $resultat -> fetch(PDO::FETCH_ASSOC);
			
			$_SESSION['pseudo'] = $membre['pseudo'];
			$_SESSION['id_membre'] = $membre['id_membre'];
			$_SESSION['email'] = $membre['email'];
			$_SESSION['avatar'] = $membre['avatar'];
			// Voilà, les infos du membre sont enregistrées dans le fichier de session, il n'y a plus qu'à rediriger le membre vers la page avec les messages.
			
			header('location:message.php');
	}	
	else{
		$msg_connexion .= '<div class="erreur">Erreur d\'identification</div>';
	}

}

?>

<!DOCTYPE html>
<html>
	<head>
		<title>Tchat</title>
		<link rel="stylesheet" href="css/styles.css" type="text/css" />
	</head>
	<body>
		<header>
		</header>
		<nav>
		</nav>
		<main>
			<h1>Accueil</h1>
			
			<div class="inscription">
				<h2>Inscription</h2>	
				<?= $msg_inscription ?>
				<form method="post" action="" enctype="multipart/form-data">
					
					<input type="text" name="pseudo" placeholder="Pseudo" />

					<input type="password" name="password" placeholder="Mot de passe" />
					
					<label>Téléchargez votre avatar :</label>
					<input type="file" name="avatar" /><br/>
					
					<input type="text" name="email" placeholder="email" />
					
					<input type="submit" value="inscription" name="inscription" />
				</form>
			</div>
			
			<div class="connexion">
				<h2>Connexion</h2>
				<?= $msg_connexion ?>
				<p>Si vous avez déjà un compte, connectez-vous :</p>
				<form method="post" action="">
					<input type="text" name="pseudo" placeholder="pseudo" />
					<input type="password" name="password" placeholder="Mot de passe" />
					<input type="submit" name="connexion" value="Connexion" />
				</form>
			</div>
		</main>
	</body>
</html>