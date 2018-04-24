<?php

echo '<pre>';
print_r($_POST);
echo '</pre>';

if($_POST){
	
	// Vérification sur les champs
	
	// déclaration des variables
	extract($_POST); // Crée une varaible au nom de l'indice et stocke la valeur à l'intérieur. S'utilise sur tous les ARRAY
		/* A pour effet :
		$prenom = $_POST['prenom'];
		$nom = $_POST['nom'];
		etc
		*/
	
	$header = "From: $email \r\n";
	$header .= "Reply-To: $email \r\n";
	$header .= "MIME-Version: 1.0 \r\n";
	$header .= "Content-type: text/html; charset=iso-8859-1 \r\n";
	$header .= "X-Mailer: PHP/" . phpversion();
	
	$contenu = "<h1>$nom - $prenom | $objet</h1>";
	$contenu .= "<ul>";
	$contenu .= "	<li>Prénom : $prenom</li>";
	$contenu .= "	<li>Nom : $nom</li>";
	$contenu .= "	<li>Email : $email</li>";
	$contenu .= "</ul><hr>";
	$contenu .= "<p>$message</p>";
	
	
	
	
	
	$destinataire = 'contact@monsite.com';
	
	
	mail($destinataire, $objet, $contenu, $header); //permet d'envoyer des emails, et elle attends 4 arguments: 
	//1- email du destinataire
	//2- objet du mail
	//3- contenu du mail
	//4- (optionnel) : En-tête du mail
}





?>


<h1>Formulaire 3</h1>

<form method="post" action="">
	<label>Prénom :</label><br>
	<input type="text" name="prenom"><br><br>
	
	<label>Nom :</label><br>
	<input type="text" name="nom"><br><br>
	
	<label>Email :</label><br>
	<input type="text" name="email"><br><br>
	
	<label>Objet :</label><br>
	<select name="objet">
		<option>Service client</option>
		<option>Service presse</option>
		<option>Problème technique</option>
		<option>Service commercial</option>
		<option>Autres</option>
	</select><br><br>
	
	<label>Message :</label><br>
	<textarea name="message" row="10" cols="30"></textarea><br><br>
	
	<input type="submit" value="Envoyer">
</form>