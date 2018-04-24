<?php

$pdo = new PDO('mysql:host=localhost;dbname=entreprise', 'root', '', array(
	PDO::ATTR_ERRMODE => PDO::ERRMODE_WARNING
));
/* $pdo est un objet de la classe PDO. Il représente notre connexion à la BDD. Cette instanciation attend 3 arguments :

la classe PDO contient plusieurs méthodes pour effectuer des requetes. Dans ce fichier nous allons voir la méthode query(). Dans le fichier pdo_avance.php nous verrons exec(), prepare(), execute().

Methode query() : 
	Valeurs de retour : 
	SELECT/SHOW :
		Succès : PDO_Statement(objet)
		Echec : false(booléen)
		
	INSERT/DELETE/UPDATE/REPLACE :
		Succès : true(booléen)
		Echec : false(booléen)

*/

//0 : Erreur volontaire de requete
//$pdo -> query("dfhdjk");
	// Par défaut les erreur sql ne sont pas affichées
	// Pour afficher les erreurs, on utilise une option PDO en mode warning (cf connexion à la ligne 4 de ce fichier)

//1 : Requete INSERT (DELETE/UPDATE/REPLACE)
$resultat = $pdo -> query("INSERT INTO employes (prenom, nom, sexe, service, date_embauche, salaire) VALUES ('Luke', 'Skywalker', 'm', 'jedi', CURDATE(), 1)");

if($resultat){
	echo 'Félicitation Luke, vous êtes ajouté !';
}

//2 : Requete SELECT (un seul résultat)
$resultat = $pdo -> query("SELECT * FROM employes WHERE id_employes = 388");

// $resultat ====> Objet PDO_Statement ====> INEXPLOITABLE
// Cet objet PDO_Statement n'est pas exploitable en l'état mais contient de nombreuses méthodes notamment fetch().

$employe = $resultat -> fetch(PDO::FETCH_ASSOC);

echo '<pre>';
print_r($employe);
echo '</pre>';

echo 'Bonjour ' . $employe['prenom'] . ' !<br>';

//3 : Requete SELECT (plusieurs résultats)
$resultat = $pdo -> query("SELECT * FROM employes");
	// $resultat ===> PDOStatement (OBJ) ===> INEXPLOITABLE
	// Combien de résultats ? ===> BOUCLE


while($employes = $resultat -> fetch(PDO::FETCH_ASSOC)){
	
	echo '<pre>';
	print_r($employes);
	echo '</pre>';
	
	echo 'Bonjour ' . $employes['prenom'] . ' !<hr>';
	
}


// La fonction fetch() de notre PDOStatement ($resultat) permet d'indexer les résultats sous forme d'un array par enregistrement.

//fetch(PDO::FETCH_ASSOC) = indexe les résultats sous forme de tableaux de manière associative
//fetch(PDO::FETCH_NUM) = indexe les résultats de manière numérique
//fetch(PDO::FETCH_OBJ) = indexe les résultats sous la forme d'un objet
//fetch() = indexe les résultats sous la forme d'un array (par résultat) indexé associativement et numériquement... Dans les options PDO on peut préciser l'indexation par défaut, cf inc/init.inc.php du dossier site/

//3bis : La fonction fetchAll() nous retourne non pas un array par résultat mais un array mutlidimentionnel avec tous les résultats.

$resultat = $pdo -> query("SELECT * FROM employes");

$employes = $resultat -> fetchAll(PDO::FETCH_ASSOC);

echo 'nombre d\'employés : ' . $resultat -> rowCount();

echo '<pre>';
print_r($employes);
echo '</pre>';

//methode for
for($i = 0; $i < count($employes); $i ++){
	echo 'Bonjour ' . $employes[$i]['prenom'] . ' !<br>';
}

//methode foreach
foreach($employes as $value){
	echo 'Bonjour ' . $value['prenom'] . ' !<br>';	
}


//4 : Dupliquer une table SQL en tableau HTML

$resultat = $pdo -> query("SELECT * FROM employes");

$employes = $resultat -> fetchAll(PDO::FETCH_ASSOC);

echo '<table border="1">';

echo '<tr>';
for($i=0; $i<$resultat -> columnCount(); $i ++){// la boucle va tourner autant de fois qu'on a de champs dans la table
	$champs = $resultat -> getColumnMeta($i);
	echo '<th>' . $champs['name'] . '</th>';
	// getColumnMeta() nous retourne toutes les infos de chaque champs sous forme d'un array. L'indice 'name' de cet array nous donne le nom du champs.
	
}
echo '</tr>';

foreach($employes as $value){
	// $value = ARRAY qui contient les infos de chaque employé tour après tour
	echo '<tr>';
	
	foreach($value as $value2){
		echo '<td>' . $value2 . '</td>';
	}
	
	echo '</tr>';
}

echo '</table>';
?>