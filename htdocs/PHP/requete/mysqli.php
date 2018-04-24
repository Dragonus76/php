<?php
$mysqli = new Mysqli('localhost', 'root', '', 'entreprise');
// $mysqli représente un oblet de la classe Mysqli. On parle d'instanciation : $mysqli est une instance de la classe Mysqli. En réalité cet objet $mysqli représente la connection à notre base de données. Pour ce faire nous devons préciser 4 arguments :
	//1- le serveur de BDD
	//2- le login
	//3- le password (sous pc : vide ; sous mac : ROOT)
	//4- le nom de la BDD

/*
echo '<pre>';
var_dump($mysqli); 
var_dump(get_class_methods($mysqli));
echo '</pre>';
*/

// On fait plutôt un var_dump sur les objets et un print_r sur les array.
//var_dump donne plus d'infos

// $mysqli est bien le premier objet de la classe Mysqli. Il contient des propriétés (variables) et des méthodes (fonctions).

/*
L'objet $mysqli contient notamment une méthode query() qui va nous permettre d'effectuer des requêtes sql auprès de la base de données.
Valeurs de retour :
	SELECT/SHOW :
		Succès : Mysqli_result(objet)
		Echec : false(booléen)
		
	INSERT/DELETE/UPDATE/REPLACE :
		Succès : true(booléen)
		Echec : false(booléen)
		
*/


//0 : Erreur volontaire de requete

/*
$mysqli -> query("qiudghqdsljkgbd") or die ('Oups, erreur sql : <br>' . $mysqli -> error); 
	- La flèche permet d'accéder à une méthode de l'objet (en l'occurence query())
	- Les erreurs sql ne s'affichent pas (par défaut). Tant mieux car les erreurs sql rendent les BDD piratables !!

La propriété error de notre objet contient le message de notre erreur et on peut l'afficher : 
	- Soit avec or die ci-dessus : permet d'afficher le texte souhaité en cas d'erreur, et stoppe l'exécution du script.
	- Soit avec echo $mysqli -> error;
*/


//1 : Requete INSERT (DELETE/UPDATE/REPLACE)

$mysqli -> query("INSERT INTO employes (prenom, nom, sexe, service, date_embauche, salaire) VALUES ('Santa', 'Claus', 'm', 'livraison', CURDATE(), '1500')");

echo 'lignes affectées : ' . $mysqli -> affected_rows;

//2 : Requete SELECT (un seul résultat)

$resultat = $mysqli -> query("SELECT * FROM employes WHERE id_employes = 350");
	// Pour les requetes SELECT il faut obligatoirement stocker le résulat dans une variable.
	
echo'<pre>';
var_dump($resultat);
echo'</pre>';

// $resultat est un objet de la classe Mysqli_result. Dommage, nous savons travailler avec des ARRAY, mais pas avec des objets... $resultat est en l'état INEXPLOITABLE!

$employe = $resultat -> fetch_assoc();

echo'<pre>';
print_r($employe);
echo'</pre>';

echo 'Bonjour ' . $employe['prenom'] . ', voici vos infos : <br>';
foreach ($employe as $indice => $valeur){
	echo $indice . ' : <strong>' . $valeur . '</strong><br>';
}

// La methode fetch_assoc() de notre objet Mysqli_result ($resultat) permet d'indexer le résultat de la requete sous la forme d'un array. Pratique!

/*
	- fetch_assoc() : array indexé de manière associative (les noms des champs dans la table deviennent les indices de l'ARRAY)
	- fetch_row() : array indexé de manière numérique.
	- fetch_array : array indexé de manière numérique et associative.
*/

//3 : Requete SELECT (plusieurs résultats)

$resultat = $mysqli -> query("SELECT * FROM employes");

// $resultat : OBJ de la classe Mysqli_result, en l'état INEXPLOITABLE!

while($employes = $resultat -> fetch_assoc()){
	echo'<pre>';
	print_r($employes);
	echo'</pre>';
}

// fetch_assoc() n'effectue pas un ARRAY pour tous les résultats, mais un ARRAY par résultat. 
// La boucle WHILE nous permet de parcourir CHAQUE résultat, pendant que fetch_assoc va indexer chaque réultat un par un et créer un tableau ARRAY pour chacun.

// Si la requete retourne un seul résultat : PAS DE BOUCLE.
// Si la requete retourne plusieurs résultats : BOUCLE
// Si la requete doit potentiellement retourner un seul résultat, mais peut-être plusieurs : BOUCLE





//4 : Dupliquer une table SQL en tableau HTML

$resultat = $mysqli -> query("SELECT * FROM employes");

echo 'Nombre d\employé(s) : ' . $resultat -> num_rows;
// La propriété num_rows de notre objet Mysqli_result compte le nombre de résultats à notre requete.

echo '<table border="1">'; // On crée le tableau

echo '<tr>'; // Ouverture de la ligne des titres
while($colonne = $resultat -> fetch_field()){
	
	echo '<th>' . ucfirst(str_replace('_', ' ', $colonne -> name)) . '</th>';
	// fetch_field() de notre objet Mysqli_result nous retourne les infos pour chaque champs dans la table. L'objet Mysqli_result est très complexe et contient beaucoup d'infos sur les enregistrements et les champs.
	// Cela nous retourne un OBJ par champs, et la propriété name de l'objet contient le nom du champs et c'est cela qui nous intéresse.
}
echo '</tr>'; // Fermeture de la ligne des titres

while($infos = $resultat -> fetch_assoc()){ // On parcourt les résultats de la requete
	echo '<tr>'; // Pour chaque enregistrement on crée une ligne dans le tableau
		foreach($infos as $indice => $valeur){ // Pour chaque enregistrement on parcourt le contenu
			if($indice == 'photo'){
				echo '<td><img src="' . $valeur . '" height="50px"></td>';
			}
			else{
				echo '<td>' . $valeur . '</td>'; // On affiche chaque info dans un <td>
			}
			
		}
	echo '</tr>'; // On ferme la ligne pour chaque enregistrement
}

echo '</table>'; // fermeture du tableau














?>