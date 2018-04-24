--Quels sont les id des livres dans la nature?
SELECT id_livre FROM emprunt WHERE date_rendu IS NULL;

-- Quels sont les titres des livres dans la nature?
SELECT titre
FROM livre
WHERE id_livre IN (
	SELECT id_livre
	FROM emprunt
	WHERE date_rendu IS NULL);
	-- On utilise IN car la requete retourne plusieurs réponse. Si on était sûr que la fonction retourne une seule réponse on pourrait utiliser =
	
-- Quels sont les id des livres que Chloe a emprunté a la bibliotheque? 
SELECT id_livre FROM emprunt WHERE id_abonne = (SELECT id_abonne FROM abonne WHERE prenom ="chloe");

-- Afficher les prénoms des abonnés ayant emprunté un livre le 19-12-2014
SELECT prenom FROM abonne WHERE id_abonne IN(SELECT id_abonne FROM emprunt WHERE date_sortie = '2014-12-19');

-- Afficher la liste des abonnés ayant déjà emprunté un livre d'Alphonse Daudet
SELECT prenom
FROM abonne
WHERE id_abonne IN (
	SELECT id_abonne FROM emprunt WHERE id_livre IN (
		SELECT id_livre FROM livre WHERE auteur = "Alphonse DAUDET"));

-- Afficher les titres des livres empruntés par Chloé
SELECT titre FROM livre WHERE id_livre IN (
	SELECT id_livre FROM emprunt WHERE id_abonne = (
		SELECT id_abonne FROM abonne WHERE prenom ="CHLOE" ));
		
-- Afficher les titres des livres que Chloe n'a pas encore emprunté 
SELECT titre FROM livre WHERE id_livre NOT IN (
	SELECT id_livre FROM emprunt WHERE id_abonne = (
		SELECT id_abonne FROM abonne WHERE prenom ="CHLOE" ));

-- Afficher les titres des livres que Chloé n'a pas encore rendu à la bibliotheque
SELECT titre FROM livre WHERE id_livre IN (
	SELECT id_livre FROM emprunt WHERE date_rendu IS NULL AND id_abonne IN (
		SELECT id_abonne FROM abonne WHERE prenom = 'Chloe'));

-- Qui est le dernier à avoir emprunté un livre?
SELECT prenom FROM abonne WHERE id_abonne IN (
	SELECT id_abonne FROM emprunt GROUP BY id_abonne ORDER BY COUNT(id_abonne) DESC LIMIT 0,1);

-- Qui a emprunté le plus de livres à la bibliotheque?
SELECT prenom FROM abonne WHERE id_abonne = (
	SELECT id_abonne FROM emprunt GROUP BY id_abonne ORDER BY COUNT(id_abonne) DESC LIMIT 0,1);
		
-- Combien de livres a emprunté Guillaume?
SELECT COUNT(*) as 'nbr_livre_guillaume' FROM emprunt WHERE id_abonne = (
	SELECT id_abonne FROM abonne WHERE prenom = 'GUILLAUME');

-- Afficher les dates de sortie et de rendu des livres qu'a empruntés Guillaume
SELECT date_sortie, date_rendu FROM emprunt WHERE id_abonne = (
	SELECT id_abonne FROM abonne WHERE prenom = 'guillaume');
		
+-------------+------------+
| date_sortie | date_rendu |
+-------------+------------+
| 2014-12-17  | 2014-12-18 |
| 2014-12-19  | 2014-12-28 |
+-------------+------------+

----------------------------------------------
-- JOINTURES
----------------------------------------------	
-- 1: on peut déclarer des alias à nos tables	
SELECT a.prenom, e.date_sortie, e.date_rendu
FROM abonne a, emprunt e
WHERE a.id_abonne = e.id_abonne
AND a.prenom = 'Guillaume';	
		
+-----------+-------------+------------+
| prenom    | date_sortie | date_rendu |
+-----------+-------------+------------+
| Guillaume | 2014-12-17  | 2014-12-18 |
| Guillaume | 2014-12-19  | 2014-12-28 |
+-----------+-------------+------------+

-- 2 : sans alias mais avec les noms entiers de tables
SELECT abonne.prenom, emprunt.date_sortie, emprunt.date_rendu
FROM abonne, emprunt		
WHERE abonne.id_abonne = emprunt.id_abonne
AND abonne.prenom = 'Guillaume';			
		
-- 1ère ligne: ce que je souhaite afficher
-- 2ème ligne: de quelle tables vais-je avoir besoin(avec ou sans alias)
-- 3ème ligne: à quelle condition puis-je lier ces différentes tables? Quel est le dénominateur commun, la jointure entre ces deux tables?	
-- Autres lignes : autres conditions de ma requête...	
		
-- EXERCICES -----------------------------------------
-- Qui a emprunté le livre Une vie sur l'année 2014? (ri possible)
SELECT a.prenom
FROM abonne a, emprunt e, livre l
WHERE a.id_abonne = e.id_abonne
AND e.id_livre = l.id_livre 
AND l.titre = 'une vie'
AND e.date_sortie LIKE '2014%';

SELECT prenom 
FROM abonne
WHERE id_abonne IN (
	SELECT ID_abonne 
	FROM emprunt 
	WHERE date_sortie LIKE '2014%' AND id_livre IN (
		SELECT id_livre
		FROM livre 
		WHERE titre = 'une vie'));

+-----------+
| prenom    |
+-----------+
| Guillaume |
| Chloe     |
+-----------+		
		
-- Nous aimerions connaitre les mouvements des livres (date sortie et rendu) ecrit par alphonse daudet (ri possible)
SELECT id_livre, date_sortie, date_rendu 
FROM emprunt
WHERE id_livre IN (
	SELECT id_livre 
	FROM livre
	WHERE auteur = 'alphonse daudet');
	
SELECT abonne.prenom, livre.titre, emprunt.date_sortie, emprunt.date_rendu
FROM abonne, livre, emprunt
WHERE abonne.id_abonne = emprunt.id_abonne
AND emprunt.id_livre = livre.id_livre
AND livre.auteur = 'alphonse daudet';

+--------+----------------+-------------+------------+
| prenom | titre          | date_sortie | date_rendu |
+--------+----------------+-------------+------------+
| Laura  | Le Petit chose | 2014-12-19  | 2014-12-22 |
+--------+----------------+-------------+------------+

-- Nous aimerions connaitre le nombre de livres empruntés par chaque abonné
SELECT abonne.prenom, COUNT(emprunt.id_livre) as'nombre emprunt'
FROM abonne, emprunt
WHERE abonne.id_abonne = emprunt.id_abonne
GROUP BY abonne.prenom;

+-----------+----------------+
| prenom    | nombre emprunt |
+-----------+----------------+
| Benoit    |              3 |
| Chloe     |              2 |
| Guillaume |              2 |
| Laura     |              1 |
+-----------+----------------+

-- Qui a emprunté quoi et quand?
SELECT abonne.prenom, emprunt.date_sortie, livre.titre
FROM abonne, emprunt, livre
WHERE abonne.id_abonne = emprunt.id_abonne
AND emprunt.id_livre = livre.id_livre;

+-----------+-------------+-------------------------+
| prenom    | date_sortie | titre                   |
+-----------+-------------+-------------------------+
| Guillaume | 2014-12-17  | Une vie                 |
| Guillaume | 2014-12-19  | La Reine Margot         |
| Benoit    | 2014-12-18  | Bel-Ami                 |
| Benoit    | 2015-03-20  | Les Trois Mousquetaires |
| Benoit    | 2015-06-15  | Une vie                 |
| Chloe     | 2014-12-19  | Une vie                 |
| Chloe     | 2015-06-13  | Les Trois Mousquetaires |
| Laura     | 2014-12-19  | Le Petit chose          |
+-----------+-------------+-------------------------+

-- Afficher les prénoms des abonnés avec les id des livres qu'ils ont empruntés
SELECT abonne.prenom, emprunt.id_livre
FROM abonne, emprunt
WHERE abonne.id_abonne = emprunt.id_abonne;

+-----------+----------+
| prenom    | id_livre |
+-----------+----------+
| Guillaume |      100 |
| Guillaume |      104 |
| Benoit    |      101 |
| Benoit    |      105 |
| Benoit    |      100 |
| Chloe     |      100 |
| Chloe     |      105 |
| Laura     |      103 |
+-----------+----------+

-- Quelle est la dernière date d'emprunt pour chaque abonné?
SELECT abonne.prenom, MAX(emprunt.date_sortie) as'denière date sortie'
FROM abonne, emprunt
WHERE abonne.id_abonne = emprunt.id_abonne
GROUP BY abonne.prenom;

+-----------+---------------------+
| prenom    | denière date sortie |
+-----------+---------------------+
| Benoit    | 2015-06-15          |
| Chloe     | 2015-06-13          |
| Guillaume | 2014-12-19          |
| Laura     | 2014-12-19          |
+-----------+---------------------+


-------------------------------------------------------
--JOINTURE EXTERNE
-------------------------------------------------------
-- On s'ajoute à la table abonne
INSERT INTO abonne (prenom, nom) VALUES ('Julie', 'Galland');

-- On ajoute un livre
INSERT INTO livre (titre, auteur) VALUES ('20000 lieux sous les mers', 'JULES VERNE');

-- Avec une jointure interne on ne voit pas apparaitre le nouvel abonné qui n'a pas emprunté de livres

SELECT abonne.prenom, emprunt.id_livre
FROM abonne, emprunt
WHERE abonne.id_abonne = emprunt.id_abonne;

+-----------+----------+
| prenom    | id_livre |
+-----------+----------+
| Guillaume |      100 |
| Guillaume |      104 |
| Benoit    |      101 |
| Benoit    |      105 |
| Benoit    |      100 |
| Chloe     |      100 |
| Chloe     |      105 |
| Laura     |      103 |
+-----------+----------+
		

-- On utilise donc une jointure externe
SELECT a.prenom, e.id_livre
FROM abonne a LEFT JOIN emprunt e	
ON a.id_abonne = e.id_abonne;
		
+-----------+----------+
| prenom    | id_livre |
+-----------+----------+
| Guillaume |      100 |
| Benoit    |      101 |
| Chloe     |      100 |
| Laura     |      103 |
| Guillaume |      104 |
| Benoit    |      105 |
| Chloe     |      105 |
| Benoit    |      100 |
| Julie     |     NULL |
+-----------+----------+		
		
-- LEFT JOIN donne la priorité à la première des deux tables déclarées (celle de gauche)
-- De la même manière, RIGHT JOIN donne la priorité à la seconde table déclarée (celle de droite)
-- Ici, si on fait un RIGHT JOIN, on ne verra pas apparaitre notre nouvel abonné car il n'est associé à aucun id_livre
-- Si on supprimait l'utilisateur Laura, une requete avec RIGHT JOIN trouverait tous les livres empruntés, dont ceux emprunté par Laura, mais ressortirait NULL en abonné.
	
-- On peut afficher les jointures externes dans tous les cas, et les jointures internes seulement lorsqu'il y a correspondance.	
		
		
		
		
		
		
		
		
		
		
		
		
		
		
		
		
		
		