<?php
echo 'Hello Word !'; // echo est une instruction qui permet d'effectuer un affichage.
echo '<br/>'; // ON peut afficher de l'HTML grâce à echo
echo 'Comment allez-vous?';

echo '<h2>Les commentaires</h2>';
// Ceci est un commentaire sur une seule ligne
/* 
Ceci est un 
commentaire
sur plusieurs lignes
*/
?>

<strong>Je suis de l'HTML !</strong>

<?php
echo '<h2>Variables : type, déclaration et affectation</h2>';

$a = 127; // Affectation de la valeur 127 dans la variable $a

echo gettype($a); // gettype() nous retourne le type d'une valeur ici INTEGER

echo '<br/>';
$b = 1.5;
echo gettype($b); // DOUBLE

echo '<br/>';
$c = 'Bonjour tout le monde !';
echo gettype($c); // STRING

echo '<br/>';
$d = '127';
echo gettype($d); // STRING

echo '<br/>';
$a = true;
echo gettype($a); // BOOLEAN

echo '<br/>';
$b = FALSE;
echo gettype($b); // BOOLEAN

// NOMENCLATURE

$z = 'test'; // OK : le nom d'une variable peut être composé d'une seule lettre

$prenom1 = 'Julie'; // OK : on peut mettre un chiffre dans une variable

// $1prenom = 'Julie'; ERREUR : on ne peut pas commencer une variable par un chiffre

// $ma super variable; ERREUR : pas d'espace dans les noms de variables

// $ma-super-variable; ERREUR : pas de tiret dans les noms de variables

$ma_super_variable; // OK : on peut utiliser l'underscore (snake case)

$maSuperSariable; // OK : on peut utiliser le camel case

$MaSuperSariable; // OK : on peut commencer par une majuscule (steady case)

//$prénom; ERREUR : pas de caractères spéciaux dans les noms de variables


echo '<h2>La concaténation</h2>';

$x = 'Bonjour';
$y = ' tout le monde !';

echo $x.$y; // On peut traduire le point de la concaténation par 'suivi de'

echo '<br/>';

echo 'Hey ! '.$x.$y.'<br/>';

echo 'Hey ! ' , $x , $y , '<br/>'; // On peut utiliser la virgule à la place du point, mais seulement avec echo

print 'Hey ! ' . $x . $y . '<br/>'; // print est une autre façon de faire un echo

echo "Hey ! $x $y <br/>"; // dans les guillemets, les varaibles sont interprétées

echo 'Hey ! $x $y <br/>'; // mais pas avec les quotes

echo '<h2>Concaténation lors de l\'affectation</h2>';


$prenom1 = 'Bruno'; // Affectation de la valeur Bruno

$prenom1 = 'Claire'; // Affectation de la valeur Claire, cela remplace Bruno

echo $prenom1;

$prenom2 = 'Nicolas'; // affectation de la valeur Nicolas
$prenom2 .= ' Marie'; // affectation de la valeur Marie qui s'ajoute à la valeur Nicolas

echo '<br/>';
echo $prenom2 . '<br/>';

echo '<h2>Constante et constantes magiques</h2>';
// CONSTANTES------------------------------------
// Une constante, tout comme une variable, permet de stocker une information. La différence se situe dans le fait que la valeur d'une varaible est... varaiblet, et celle d'une constante est de fait constante!

// define('NOMDECONST', 'valeur');
define('CAPITALE', 'Paris'); // LA fonction define nous permet de créer une constante. Elle prend 2 arguments :
	/* 
	-1 : le nom de la constante toujours en majuscules
	-2 : la valeur de la constante 	*/

echo CAPITALE . '<br/>';

// CONSTANTES MAGIQUES--------------------------
// Ce sont des constantes qui appartiennent au langage. S'écrit avec 2 underscores de chaque côté!

echo __DIR__ . '<br/>'; // Directory : dossier courant
echo __FILE__ . '<br/>'; // File : fichier courant
echo __LINE__ . '<br/>'; // Line : ligne courante
// Il existe aussi __FUNCTION__ , __CLASS__ , __NAMESPACE__ , __METHOD__

// EXERCICE
// Afficher bleu - blanc - rouge en utilisant trois variables et la concaténation

$a = 'bleu';
$b = 'blanc';
$c = 'rouge';

echo '<br/>';
echo $a , ' - ' , $b , ' - ' , $c;
echo '<br/>';
echo "$a - $b - $c";


echo '<h2>Opérateurs arithmétiques</h2>';

$a = 10;
$b = 2;

echo $a + $b; // Affiche 12
echo '<br/>';
echo $a - $b; // Affiche 8
echo '<br/>';
echo $a * $b; // Affiche 20
echo '<br/>';
echo $a / $b; // Affiche 5
echo '<br/>';

$c = 10;
$d = 4;
echo $c % $d; // Affiche 2 (modulo=reste de la division)
echo '<br/>';

echo $a += $b; // Affiche 12 car $a = $a + $b
echo '<br/>';
echo $a -= $b; // Affiche 10 car $a = $a - $b
echo '<br/>';
echo $a *= $b; // Affiche 20 car $a = $a * $b
echo '<br/>';
echo $a /= $b; // Affiche 10 car $a = $a / $b

// exemple dans un site de e.commerce
$montant = 120;
$montant *= 1.20; //application de la tva

$transport = 6;
$montant += $transport; //ajout du coût du transport

$code_promo = 10;
$montant -= $code_promo; //retrait du montant de la promotion

echo '<br/>';
echo $montant;


echo '<h2>Structures conditionnelles</h2>';


// empty() : vérifie si quelque chose est vide, égale à zéro ou false
// isset() : vérifie si quelque chose existe

$variable1 = 0; //false
$variable2 = ''; //vide

if(empty($variable1)){ // retourne true (car égal à zéro)
	//traitements à effectuer
	echo 'oui c\'est vrai <br>';
}

if(empty($variable2)){ // retourne true (car vide)
	//traitements à effectuer
	echo 'oui c\'est vrai <br>';
}

if(isset($variable1)){ // retourne true (car existe)
	//traitements à effectuer
	echo 'oui c\'est vrai <br>';
}

if(isset($variable2)){ // retourne true (car existe, même si elle est vide)
	//traitements à effectuer
	echo 'oui c\'est vrai <br>';
}

if(isset($variable3)){ // retourne false car $variable3 n'existe pas
	//traitements à effectuer
	echo 'oui c\'est vrai <br>';
}

else{
	echo 'non ce n\'est pas vrai <br>';
}


// Les SC et les comparaisons-------------------------------

$a = 10;
$b = 5;
$c = 2;

if($a>$b){
	echo 'oui A est supérieur à B <br>';
}
else{
	echo 'non B est supérieur ou égal à A <br>';
}

if($a > $b && $b > $c){
	echo 'Oui A est supérieur à B et B est supérieur à C <br>';
}
// && (ou AND) vérifie que toutes les conditions soient réunies
/*
	true && true ==> true
	true && false ==> false
	false && true ==> false
	false && false ==> false
*/

//--------------------------
if($a == 9 || $b > $c){
	echo 'Oui, pour au moins une des deux conditions <br>';
}
// || (ou OR) vérifie qu'au moins une des deux conditions soit vraie
/*
	true || true ==> true
	true || false ==> true
	false || true ==> true
	false || false ==> false
*/

//--------------------------
if($a == 10 XOR $b == 6){
	echo 'Oui, pour seulement l\'une des deux conditions ! <br>';
}
// XOR vérifie si, et seulement si, l'une des deux conditions est vraie. Si les deux fonctionnent ça ne retourne pas true.
/*
	true || true ==> false
	true || false ==> true
	false || true ==> true
	false || false ==> false
*/

// IF, ELSEIF, ELSE-----------------------------
if($a == 8){
	echo 'A est égal à 8 <br>';
}
elseif($a != 10){
	echo 'A est de 10 et de 8  <br>';
}
else{
	echo 'A est égal à 10 <br>';
}

// '=' affectation
// '==' comparaisons
// '===' strict comparaison (type et valeur)

echo '<h2>Condition switch</h2>';

$couleur = 'bleu';

switch($couleur){
	case 'bleu' : 
		echo 'Vous aimez le bleu';
	break;
	case 'vert' : 
		echo 'Vous aimez le vert';
	break;
	case 'rouge' : 
		echo 'Vous aimez le rouge';
	break;
	default : 
		echo 'Vous n\'aimez ni le bleu, ni le vert, ni le rouge';
	break;	
}
echo '<br>';

// idem en if, elseif, else
if($couleur == 'bleu'){
	echo 'Vous aimez le bleu <br>';
}
elseif($couleur == 'vert'){
	echo 'Vous aimez le vert <br>';
}
elseif($couleur == 'rouge'){
	echo 'Vous aimez le rouge <br>';
}
else{
	echo 'Vous n\'aimez ni le bleu, ni le vert, ni le rouge <br>';
}


echo '<h2>Les fonctions prédéfinies</h2>';
// Elles permettent de réaliser des traitements spécifiques et appartiennent au langage. Il en existe plusieurs centaines, vous pouvez les découvrir sur la doc PHP : http://php.net

// date(); La fonction date() nous retourne une date et prend deux arguments.
	/*
	1- Le format de la date que l'on souhaite récupérer
	2- Le timestamp (optionel : par défaut la date du jour)
	*/

echo date('d/m/y'); // 19/12/17
echo '<br>';
echo date('d/m/Y'); // 19/12/2017
echo '<br>';
echo date('D/M/Y'); // Tue/Dec/2017
echo '<br>';
echo date('d/m/Y H:i:s'); // date et heure exacte de la demande
echo '<br>';
echo date('d/m/Y H:i:s', 301571400); // 23/07/1979 10:50:00
echo '<br>';
echo date('d/m/Y H:i:s', 1385143200); // 22/11/2013 19:00:00
echo '<br>';

// Fonctions prédéfinies sur les chaînes de caractères------------

$email = 'juliegalland@yahoo.fr';

// strpos();  retourne la position d'un ou plusieurs caractère(s) dans une chaîne de caractères. Elle prend deux arguments : 
	/*
	1- : la CC sur laquelle on travaille
	2- : le ou les caractères recherché(s)
	
	valeurs de retour :
	- Succès : N (INT)
	- Echec : false (BOOL)
	*/

echo '<br>';
echo strpos($email, '@');
echo '<br>';
	
$phrase1 = 'Nous sommes mardi, et il fait froid !';	
$phrase2 = 'Nous sommes mardi, et il fait très froid !';	

// strlen(); retourne le nombre de caractères d'une CC. La fonction attend un seul argument (STRING) et nous retourne soit un INT (Succès) soit FALSE (Echec).
	
echo strlen($phrase1); // retourne 37
echo '<br>';
echo strlen($phrase2); // retourne 43 au lieu de 42 à cause de l'accent qui rajoute 1 octet
echo '<br>';
// Pour éviter les problèmes d'accent : 
echo strlen(utf8_decode($phrase2)); // retourne 42
echo '<br>';
	
$texte = 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Aenean nec augue diam. Nunc ac blandit risus, sed rhoncus diam. Phasellus id neque dui. Quisque quis pretium orci. Quisque mattis tellus at justo lobortis, scelerisque bibendum nunc ornare. Proin eget ipsum neque. Sed ipsum dolor, tristique in rhoncus et, sagittis ac nulla.';
	
// substr(); permet de récupérer une partie d'une chaîne de caractère. La fonction attend de 2 à 3 arguments
	/*
	1- la CC sur laquelle on travaille
	2- la position de départ
	3- la position de fin(optionnel. Par défaut : jusqu'à la fin de la CC)
	
	valeurs de retour :
	- Succès : STRING
	- Echec : false (BOOL)
	*/

echo substr($texte, 0, 30) . '...<a href="">Voir la suite</a>';
echo '<br>';
	
echo '<h2>Fonctions utilisateurs</h2>';
// Les fonctions utilisateurs sont les fonctions que nous allons créer nous-même, afin d'assurer des traitements particuliers, qui ne sont pas prévus dans le langage.
	
// 1- déclaration :
function bonjour(){
	// traitements à effectuer
	echo 'Bonjour';
}

// 2- exécution :
bonjour();
echo '<br>';

// Nous avons déclaré une fonction dont l'objectif est d'afficher la CC 'Bonjour'. Cette fonction n'attendait pas d'argument.

// 1- déclaration :
function hello($arg){
	return 'Hello ' . $arg . '<br>';
}

// 2- exécution :
echo hello('Julie');

$prenom = 'Dolly';
echo hello($prenom);

// Déclaration d'une fonction pour simplifier les titres
function titre($arg){
	echo '<h2>' . $arg . '</h2>';
}

echo titre('Mon nouveau titre');

// Fonction pour calculer un prix HT en TTC
// 1- déclaration :
function appliqueTVA($prixHT){
	return $prixHT * 1.2;
}

// 2- exécution :
echo 'Le prix HT de 122€ HT correspond à ' . appliqueTVA(122) . ' € TTC <br>';

// Exercice : créer une fonction appliqueTVA2() en améliorant le fonctionnement afin de pouvoir choisir quel taux de tva on utilise (5.5, 10, 20). Une fonction peut recevoir de un à plusieurs arguments...
$prixHT = 100;
$tauxTVA = 1.055;

function appliqueTVA2($prixHT, $tauxTVA){
	if(is_numeric($prixHT) && is_numeric($tauxTVA)){
		if($tauxTVA == 1.055 OR $tauxTVA == 1.1 OR $tauxTVA == 1.2){
			return $prixHT * $tauxTVA;	
		}
		else{
			echo "Vous n'avez pas choisi un taux de TVA valide.";
		}
	}
	else{
		return false;
	}
}

echo 'Le prix HT de ' . $prixHT . '€ HT, avec une TVA de ' . $tauxTVA . ', correspond à ' . appliqueTVA($prixHT, $tauxTVA) . ' € TTC <br>';

$tarifHT = 200;
$choixTVA = 5.5;

function choisirTVA($tarifHT, $choixTVA){
	// globalpermet de récupérer une variable à portée globale dans un espace local;
	global $choixTVA;
	switch($choixTVA){
		case 5.5 :
			return $tarifHT * 1.055;
		break;
		case 10 :
			return $tarifHT * 1.1;
		break;
		case 20 :
			return $tarifHT * 1.2;
		break;
		
		default :
			return false;
		break;
	}
}

echo choisirTVA($tarifHT, $choixTVA);


titre('Inclusion de fichiers');

/*<?php echo date('Y'); ?>
<?= date('Y'); ?> Pour inclure un echo de php dans du html, on peut faire cette version raccourcie. Ne marche QUE avec echo.*/

// Les inclusions de fichier permettent d'inclure des parties communes à toutes les pages (exemple : header, nav, footer...) Cela se comporte comme un copier-coller et l'avantage c'est que l'on peut modifier les parties communes à un seul endroit.

// include() ==> S'il y a une erreur dans le fichier inclus, l'erreur est affichée puis le script continue.
// require() ==> S'il y a une erreur dans le fichier inclus, alors le script s'arrête.
// include_once() ==> Même chose que include, mais si le fichier est inclus plusieurs fois, il ne sera affiché qu'une seule fois
// require_once() ==> Même chose que require, mais si le fichier est inclus plusieurs fois, il ne sera affiché qu'une seule fois

titre('Les structures itératives : les boucles');
// La boucle while -----------------------------
$i = 0;
while($i < 3){
	echo $i . '---';
	$i ++;
}
echo '<br>';

// exercice : afficher avec une boucle while : 0---1---2
$i = 0;
while($i < 5){
	if($i == 0){
		echo $i;
	}
	else{
		echo '---' . $i;
	}
	$i ++;
}
echo '<br>';

// Autre version
$j = 0;
$index = 10;
while($j < $index){
	if($j < $index - 1){
		echo $j . '---';
	}
	else{
		echo $j;
	}
	$j ++;
}
echo '<br>';


// La boucle for -------------------------------
for($i = 0; $i < 3; $i ++){
	echo $i . '---';
}
echo '<hr>';

// Exercices
// 1- A l'aide d'une boucle for, afficher 0123456789
for($i = 0; $i < 9; $i ++){
	echo $i;
}
echo '<br>';

// 2- A l'aide d'une boucle for, afficher dans un tableau (une seule ligne) 0123456789
echo '<table border="1">';
echo '<tr>';
for($i = 0; $i <= 9; $i ++){
	echo '<td style="border: 1px solid">' . $i .'</td>';
}
echo '</tr>';
echo '</table>';
echo '<br>';

// 3- A l'aide d'une boucle afficher dans un tableau de 0 à 99

// version avec modulo
echo '<table border="1">';
echo '<tr>';
for($i = 0; $i <= 99; $i ++){
	if($i%10 == 0 && $i != 0){
		echo '</tr><tr>';
	}
	echo '<td>' . $i . '</td>';
	}
echo '</tr>';
echo '</table>';
echo '<br>';

// version calcul
echo '<table border="1">';
for($i = 0; $i <= 9; $i ++){
	echo '<tr>';
	for($j = 0; $j <= 9; $j ++){
		echo '<td>' . ((10*$j)+$i) .'</td>';
	}
	echo '</tr>';
}
echo '</table>';
echo '<br>';

// version dev
$k = 0;
echo '<table border="1">';
for($i = 0; $i <= 9; $i ++){
	echo '<tr>';
	for($j = 0; $j <= 9; $j ++){
		echo '<td>'. $k .'</td>';
		$k ++;
	}
	echo '</tr>';
}
echo '</table>';
echo '<br>';


titre('Les tableaux de données : array');

$liste = array('Yakine', 'Aleksa', 'JM', 'Kamel', 'Thomas');

echo '<pre>';
print_r($liste);
echo '</pre>';

echo 'bonjour ' . $liste[2] . ' !<br>';

titre('Boucle foreach, pour les array');

$tab[] = 'France';
$tab[] = 'Italie';
$tab[] = 'Espagne';
$tab[] = 'Angleterre';
$tab[] = 'Portugal';

echo '<pre>';
print_r($tab);
echo '</pre>';

$tab[] = 'Belgique';

echo '<pre>';
print_r($tab);
echo '</pre>';

$tab[4] = 'Suisse';

echo '<pre>';
print_r($tab);
echo '</pre>';

// La boucle foreach
foreach($tab as $valeur){
	echo $valeur . '<br>';
}
// le mot AS fait partie du langage, il est obligatoire.
// $valeur se comporte comme un curseur qui parcourt le tableau et stocke à chaque tour de boucle la valeur qu'il trouve

foreach($tab as $indice => $valeur){
	echo 'A l\'indice ' . $indice . ' se trouve la valeur : ' . $valeur . '<br>';
}

// Lorsqu'il y a deux variables dans les paramètres de la boucle foreach, la première stocke l'indice, et la seconde stocke la valeur.

for($i = 0; $i < count($tab); $i ++){
	echo 'A l\'indice ' . $i . ' se trouve la valeur : ' . $tab[$i] . '<br>';
}// Donne le même résultat en boucle for
// count() = sizeof() : fonction qui permet de compter le nombre d'éléments dans un array.

$employe = array(
	'id_employes' 	=> '350',
	'prenom' 		=> 'Jean-Pierre',
	'nom' 			=> 'Laborde',
	'sexe' 			=> 'm',
	'service' 		=> 'Direction',
	'salaire' 		=> 5000
);

echo '<pre>';
print_r($employe);
echo '</pre>';


titre('tableau multidimensionnel');

$tab_multi = array(

	0 => array(
		'prenom' => 'Julien',
		'nom' => 'Cottet'
	),
	
	1 => array(
		'prenom' => 'Nicolas',
		'nom' => 'Lafaye'
	),
	
	2 => array(
		'prenom' => 'Amandine',
		'nom' => 'Thoyer'
	),
	
);

echo '<pre>';
print_r($tab_multi);
echo '</pre>';

?>