-- Sur la console pour accéder au serveur de BDD, on tape la commande suivante : mysql -u root -p

-- Le langage sql n'est pas sensible à la casse. Par contre, par convention, les mots clés sont toujours en MAJ
SHOW DATABASES; 
--Montre-moi toutes les databases sur le serveur

CREATE DATABASE entreprise;
-- Crée la BDD entreprise

DROP DATABASE entreprise;
-- Supprime la BDD entreprise

USE nom_de_bdd
-- Se connecter à l'une des bases

SHOW TABLES;
-- afficher toutes les tables dans la bdd

DESC employes;
-- description de la table employes

-------------------------------------------
-- SELECT
-------------------------------------------

-- Je souhaite afficher toutes les infos des employés de l'entreprise
SELECT id_employes, prenom, nom, sexe, service, date_embauche, salaire FROM employes;
SELECT * FROM employes; --fait la même chose

-- Je souhaite afficher tous les prénoms et noms de tous les employés de l'entreprise
SELECT prenom, nom FROM employes;

--DISTINCT ---------------------------------
-- Quels sont les différents services de mon entreprise?
SELECT DISTINCT service FROM employes; --permet d'éviter les doublons

-- CONDITION WHERE -------------------------
-- Je souhaite afficher les employes du service informatique
SELECT nom, prenom, service FROM employes WHERE service ='informatique';

-- BETWEEN+AND ------------------------------
-- Je souhaite afficher les employer embauchés entre 2010 et aujourd'hui
SELECT nom, prenom, date_embauche FROM employes WHERE date_embauche BETWEEN '2010-01-01' AND '2017-12-14';

SELECT nom, prenom, date_embauche FROM employes WHERE date_embauche BETWEEN '2010-01-01' AND CURDATE(); 

-- BETWEEN + AND = entre telle et telle valeur
-- CURDATE() = fonction sql qui retourne la date du jour
-- NOW() = Fonction sql qui retourne la date du jour et l'heure actuelle

-- LIKE -------------------------------------
-- Je souhaite connaitre tous les salariés dont le prénom commence par S
SELECT prenom, nom FROM employes WHERE prenom LIKE 's%';
SELECT prenom, nom FROM employes WHERE prenom LIKE 'c%';
SELECT prenom, nom FROM employes WHERE prenom LIKE '%-%';

-- OPERATEUR ----------------------------------
-- Afficher tous les employés sauf ceux du service informatique
SELECT prenom, nom, service FROM employes WHERE service !='informatique';

SELECT prenom, nom, service FROM employes WHERE service <>'informatique'; -- fait pareil

-- Quels sont les employés gagnant plus de 3000€?
SELECT prenom, nom, salaire FROM employes WHERE salaire >3000;

-- Quels sont les employés recrutés avant le 15 juin 2007?
SELECT prenom, nom, date_embauche FROM employes WHERE date_embauche >'2007-06-15';

-- ORDER BY --------------------------------------
-- Affichage des employes dans l'ordre alpha des prénoms 
SELECT prenom, nom FROM employes ORDER BY prenom ASC; -- ascendant=croissant : valeur facultative car par defaut

-- inverse
SELECT prenom, nom FROM employes ORDER BY prenom DESC; -- descendant=décroissant

-- LIMIT -----------------------------------------
-- Limite permet d'afficher une partie des résultats obtenus. Le premier chiffre correspond au point de départ, le deuxième au nombre de résultat à afficher. Pratique pour la pagination
SELECT prenom FROM employes ORDER BY prenom LIMIT 0,3;

SELECT prenom FROM employes ORDER BY prenom LIMIT 3,3;

SELECT prenom FROM employes ORDER BY salaire DESC LIMIT 0,1;

-- CALCUL et Alias ----------------------------
-- Afficher le salaire annuel de chaque employé
SELECT prenom, nom, salaire*12 FROM employes;

SELECT prenom, nom, salaire*12 AS 'salaire_annuel' FROM employes;

-- SOMME
-- Afficher la masse salariale de l'entreprise
SELECT SUM(salaire*12) FROM employes;

SELECT SUM(salaire*12) AS 'masse_salariale' FROM employes;

-- AVG (average) ------------------------
-- Afficher le salaire moyen des employés
	-- moyenne
SELECT AVG(salaire) FROM employes;
	-- moyenne arrondie à un entier
SELECT ROUND(AVG(salaire)) FROM employes;
	-- moyenne arrondie à un chiffre après la virgule
SELECT ROUND(AVG(salaire), 1) FROM employes;

-- COUNT -------------------------------
--Afficher le nombre de femmes dans l'entreprise
SELECT COUNT(*) FROM employes WHERE sexe='f';
SELECT * FROM employes WHERE sexe='f';
SELECT prenom FROM employes WHERE sexe='f';

-- MIN et MAX -------------------------
-- Afficher le salaire minimum
SELECT MIN(salaire) FROM employes;
SELECT MAX(salaire) FROM employes;

-- Requête imbriquée --------------------------
-- Afficher la personne qui gagne le plus petit salaire
SELECT prenom, salaire FROM employes WHERE salaire = (SELECT MIN(salaire) FROM employes);
-- les requêtes imbriquées permettent de trouver une valeur inconnue et de cibler un résultat en fonction de cette valeur

-- IN ---------------------------------------
--Afficher les employés des services 'commercial' et 'informatique'
SELECT prenom, nom, service FROM employes WHERE service IN ('commercial', 'informatique');

-- NOT IN ---------------------------------------
--Afficher les employés qui ne sont pas dans les services 'commercial' et 'informatique'
SELECT prenom, nom, service FROM employes WHERE service NOT IN ('commercial', 'informatique');

-- AND et OR ------------------------------
--Afficher les employés du service commercial gagnant moins de 2000€
SELECT prenom, nom, salaire, service
FROM employes
WHERE salaire <2000 AND service="commercial";

--Afficher les employés des services 'commercial' et 'informatique'
SELECT prenom, nom, service
FROM employes
WHERE service="commercial"
OR service="informatique";

SELECT prenom, nom, salaire, service
FROM employes
WHERE service="commercial" AND salaire=1900
OR service="commercial" AND salaire=2300;
-- on peut l'écrire
-- WHERE service='commercial' 
-- AND (salaire = 2300 OR salaire = 1900);
-- !ATTENTION OR est prioritaire dans les fonctions

-- GROUP BY ----------------------------------
-- Afficher le nombre d'employés par services
SELECT service, COUNT(*) 
FROM employes
GROUP BY service;
-- On ne peut pas utiliser WHERE avec GROUP BY. On utilise HAVING.










