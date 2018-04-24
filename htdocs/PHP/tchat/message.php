<?php
session_start(); // Récupère les infos de la BDD grace à $_SESSION
$pdo = new PDO('mysql:host=localhost;dbname=tchat', 'root', '', array(
	PDO::ATTR_ERRMODE => PDO::ERRMODE_WARNING
)); // Connexion à la BDD

// Traitements pour la déconnexion
if(isset($_GET['action']) && !empty($_GET['action']) && $_GET['action']=='deconnexion'){
	//si une action de déconnexion est transmise via l'url
	session_destroy(); // on supprime le fichier de session
	header('location:index.php'); // on redirige vers la page de connexion
}


// Traitements pour récupérer tous les messages
$req = "SELECT m.*, mem.*
FROM message m, membre mem
WHERE mem.id_membre = m.id_membre";

$resultat = $pdo -> query($req);

$messages = $resultat -> fetchAll(PDO::FETCH_ASSOC);
echo '<pre>';
print_r($messages);
echo '</pre>';



// Traitement pour enregistrer un nouveau message
if($_POST && !empty($_POST['message'])){ // Si le formulaire d'ajout de message est activé
    
    $resultat = $pdo -> prepare(" INSERT INTO message (id_membre, date_enregistrement, contenu) VALUES ($_SESSION[id_membre], NOW(), :contenu) ");
    
    $resultat -> bindParam(':contenu', $_POST['message'], PDO::PARAM_STR); 
    
    if($resultat -> execute()) {
        header('location:message.php');
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
			<a class="btn" href="?action=deconnexion">Deconnexion</a>
		</nav>
		<main>
			<h1>Tchat WF3 - DIW 13</h1>
			
			<h2>Bonjour <?= $_SESSION['pseudo'] ?> ! </h2>
			<p>Bienvenue sur le tchat des DIW13, n'hésitez pas à communiquer avec nous :) </p>
			
			
			<?php foreach($messages as $valeur) : ?>
				<?php extract($valeur) ?>
				<?php if($valeur['id_membre'] == $_SESSION['id_membre']) : ?>
					<!-- debut commentaire user en cours -->
					<div class="comment user_connecte">
						
						<div class="comment_in">
							<div class="img">
								<img src="image/<?= $avatar ?>" height="25px" />
								<p class="auteur">Par <?= $pseudo ?>, le <?= $date_enregistrement?></p>
							</div>
							<div class="content">
								
								<p class="message"><?= $contenu ?></p>
							</div>
						</div>
						
						<div class="triangle"></div>
					</div>
					<!-- fin commentaire user en cours -->
					
					
				<?php else :?>
					<!-- Début commentaire -->
				<div class="comment">
					<div class="triangle"></div>
					<div class="comment_in">
						<div class="img">
							<img src="image/<?= $avatar ?>" height="25px" />
							<p class="auteur">Par <?= $pseudo ?>, le <?= $date_enregistrement?></p>
						</div>
						<div class="content">
							
							<p class="message"><?= $contenu ?></p>
						</div>
					</div>
				</div>
				<!-- Fin commentaire -->
					
					
				<?php endif; ?>
				
			<?php endforeach; ?>
			
				
			
			<hr/>
			<h4>Nouveau message : </h4>
			<form method="post" action="" class="tchat">
				<textarea name="message" placeholder="Votre Message"></textarea>
				<input type="submit" name="envoi" value="Envoyer" />
			</form>
			
		</main>
	</body>
</html>