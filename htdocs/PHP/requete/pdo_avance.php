<?php

//requete/pdo_avance.php

/*
Il y a plusieurs manières d'effectuer des requêtes avec PDo : query(), prepare(), exec(), execute(). 

------
Méthode query() : CF fichier pdo.php

------
Méthode exec() : Normalement les requêtes INSERT, UPDATE, DELETE et REPLACE doivent être effectuées depuis la méthode exec() et non query() même si cela fonctionne. Cela est du aux valeurs de retour : 

Valeurs de retour : 
	Succès : N (INT), nbre de lignes affectées par notre requête 
	Echec : FALSE (Bool)
	
------
Méthode prepare() puis execute() : Lorsque notre requête contient des données sensibles (POST, GET), on va d'abord préparer la requête puis l'exécuter. Cela permet de traiter les données sensibles et ainsi éviter les injections SQL. En d'autres termes, cela va effectuer htmlentities() et addslashes() à notre place. 

- prepare() : permet de préparer une requete sans l'éxécuter
- execute() : execute la requête préparée

Valeurs de retour : 
	- prepare() :
		Succès ou echec : PDOStatement (OBJ)
	
	- execute() : 
		Succès : TRUE (Bool)
		echec : FALSE (Bool)

-------
Quand utiliser quelle méthode ? 

$resultat = $pdo -> query("SELECT * FROM employes"); 
----
$resultat = $pdo -> query("SELECT * FROM employes WHERE prenom = "jean-pierre");
----
$resultat = $pdo -> prepare("SELECT * FROM employes WHERE id_employes = $_GET[id]");
// traitements...
$resultat -> execute(); // execute() appartient à $resultat, notre obj PDOStatement
----
$resultat = $pdo -> exec("INSERT INTO employes (prenom, nom) VALUES ('toto', 'tata')");
----
$resultat = $pdo -> prepare("INSERT INTO employes (prenom, nom) VALUES ('$_POST[prenom]', '$_POST[nom]')");
// traitements...
$resultat -> execute();

*/

// Connexion en mode erreur EXCEPTION: 

$pdo = new PDO('mysql:host=localhost;dbname=entreprise', 'root', '', array(
	PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
));

try{
	
	// 0 : Erreur SQL Volontaire
	// $resultat = $pdo -> query("sdqsqsdqsdqsdqs");
	
	//1 : Requête INSERT (REPLACE, UPATE, DELETE) avec query
	//2 : Requête SELECT (1 résultat)
	//3 : Requête SELECT (plusieurs résultats) fetch et fetchAll
	//4 : Duplicat d'une table SQL en tableau HTML
	
	//5 : Requête UPDATE avec exec() :
	$resultat = $pdo -> exec("UPDATE employes SET salaire = (salaire + 100)");
	echo 'Nombre de ligne(s) affectée(s) : ' . $resultat . '<br/>';
	
	if($resultat != FALSE){
		echo 'Félicitations, vous gagnez tous 100€ de plus'; 
	}
	
	
	//6 : Passage d'argument avec prepare() + execute()
		// -> Marqueur non-nominatif '?'
		$_POST['prenom'] = 'Amandine';
		$_POST['nom'] = 'Thoyer';
		
		//Exemple avec un seul marqueur
		$resultat = $pdo -> prepare("SELECT * FROM employes WHERE prenom = ? ");
		// '?' est un marqueur qui permet de dire à la requête : 'il va y avoir une sonnée sensible'.
		$resultat -> execute(array($_POST['prenom']));
		
		//Exemple avec deux marqueurs :
		$resultat = $pdo -> prepare("SELECT * FROM employes WHERE prenom = ? AND nom = ? ");
		$resultat -> execute(array($_POST['prenom'], $_POST['nom'])); //ATTENTION à les mettre dans l'ordre de la table
		
		
		// -> Marqueur nominatif ':'
		$_POST['prenom'] = 'Amandine';
		$_POST['nom'] = 'Thoyer';
		
		$resultat = $pdo -> prepare("SELECT * FROM employes WHERE prenom = :prenom AND nom = :nom");
		$resultat -> execute(array(
			'nom' => $_POST['nom'],
			'prenom' => $_POST['prenom']
		)); // Cette fois, pas besoin de se soucier de l'ordre, pratique!
		
		/*
		$resultat = $pdo -> prepare("INSERT INTO employes(prenom, nom, sexe, service, date_embauche, salaire, photo) VALUES (:prenom, :nom, :sexe, :service, :date_embauche, :salaire, :photo)")
		$resultat -> execute($_POST);
		*/
		
		/*
		Les marqueurs permettent, lors des requêtes préparées, de reporter le passage (la transmition) des données sensibles dans la requête. Une requête préparée est prévenue qu'elle va recevoir des données sensibles qui devront être traitées comme telles.
		Il existe deux types de marqueurs : le marqueur non nominatif '?' et le marqueur nominatif ':'
		Dans les deux cas on passe la (les) donnée(s) sensible(s) en argument de la méthode execute. Cet argument est un array dans lequel sont stockées les valeurs sensibles :
		-> avec ? === dans l'ordre de la requête
		-> avec : === peu importe l'ordre tant que l'indice de l'array correspond au nom du marqueur
		*/
		
				
	//7 : Passage d'argument BindParam()
	$_POST['prenom'] = 'Amandine';
	$_POST['nom'] = 'Thoyer';
	
	$resultat = $pdo -> prepare("SELECT * FROM employes WHERE prenom = :prenom AND nom = :nom");
	
	$resultat -> bindParam(':prenom', $_POST['prenom'], PDO::PARAM_STR);
	$resultat -> bindParam(':nom', $_POST['nom'], PDO::PARAM_STR);
	$resultat -> execute(); // retourne TRUE ou FALSE
	
	//---
	
	$_GET['id'] = 350;
	
	$resultat = $pdo -> prepare("SELECT * FROM employes WHERE id_employes = :id_employes");
	
	$resultat -> bindParam(':id_employes', $_GET['id'], PDO::PARAM_STR);
	$resultat -> execute(); // retourne TRUE ou FALSE
	
	//8 : Passage d'argument BindValue()
	$resultat = $pdo -> prepare("SELECT * FROM employes WHERE id_employes = :id_employes");
	
	$resultat -> bindValue(':id_employes', '350', PDO::PARAM_STR);
	$resultat -> execute(); // retourne TRUE ou FALSE
	
	/*
	bindParam() et bindVlaue() nous permettent de passer les valeurs sensibles dans nos requêtes préparées pour chaque marqueur nominatif.
	L'avantage de ces deux fonctions est que cela ajoute le fait de caster(inspecter) les valeurs avant de les envoyer à la requête. Cela constitue un rempart supplémentaire en terme de sécurité et d'intégrité des données. La différence entre bindParam() et bindVlaue() est que bindValue() accepte les variables mais aussi les valeurs.
	*/
	
	
	//9 : Fetch directement dans la requête query
	$resultat = $pdo -> query("SELECT * FROM employes", PDO::FETCH_ASSOC);
	
	echo '<pre>';
	var_dump($resultat);
	echo '</pre>';
	
	foreach($resultat as $valeur){
		echo 'Bonjour' . $valeur['prenom']. '<br>';
	}
	
	//10 : id du dernier enregistrement
	$resultat = $pdo -> exec("INSERT INTO employes (prenom, nom, sexe, service, date_embauche, salaire, photo) VALUES ('Goku', 'San', 'm', 'Sayan', CURDATE(), '1', 'photo.jpg')");
	
	echo 'id du dernier enregistrement : ' . $pdo -> lastInsertId();
	
}

catch(PDOException $e){
	
	echo '<div style="background:red; color: white; padding:20px;" >';
	echo '<p>Erreur SQl :</p>';
	echo 'Message : ' . $e -> getMessage() . '<br/>';
	echo 'Code : ' . $e -> getCode() . '<br/>';
	echo 'File : ' . $e -> getFile() . '<br/>';
	echo 'Ligne : ' . $e -> getLine() . '<br/>';
	echo '</div>';
	
	$f = fopen('error.txt', 'a');
	$erreur = date('d/m/Y - H:i:s') . ' - Error SQL : '. "\r\n";
	$erreur .= 'Message : ' . $e -> getMessage() . "\r\n\r\n";
	
	fwrite($f, $erreur);
	fclose($f);
	exit;
}
?>