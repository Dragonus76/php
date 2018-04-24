screen task http://192.168.1.55:7070
-- Qui conduit la voiture 503?
-- réponse en RI :
SELECT prenom FROM conducteur WHERE id_conducteur IN(
	SELECT id_conducteur
	FROM association_vehicule_conducteur
	WHERE id_vehicule = 503);
	
+----------+
| prenom   |
+----------+
| Philippe |
+----------+

-- réponse en jointure interne :
SELECT c.prenom
FROM conducteur c, association_vehicule_conducteur avc
WHERE c.id_conducteur = avc.id_conducteur
AND avc.id_vehicule = 503;

-- réponse en jointure externe :
SELECT c.prenom
FROM conducteur c INNER JOIN association_vehicule_conducteur avc
ON c.id_conducteur = avc.id_conducteur
AND avc.id_vehicule = 503;

-- INNER JOIN est une jointure interne qui s'écrit comme une jointure externe ^^

-- INNER JOIN affiche les résultats ayant une correspondance (comme la jointure interne)
-- LEFT JOIN : affiche les résultats en priorisant la table de gauche, même s'il n'y a pas de correspondance.
-- RIGHT JOIN : affiche les résultats en priorisant la table de droite, même s'il n'y a pas de correspondance.

-- EXERCICES
-- 1- Quels sont les véhicules conduits par Morgane?
SELECT v.marque, v.modele
FROM vehicule v, conducteur c, association_vehicule_conducteur avc
WHERE v.id_vehicule = avc.id_vehicule
AND avc.id_conducteur = c.id_conducteur
AND c.prenom = 'morgane';

+---------+--------+
| marque  | modele |
+---------+--------+
| Citroen | C8     |
+---------+--------+

-- 2- Qui a conduit la Peugeot 807?
SELECT c.prenom
FROM conducteur c, vehicule v, association_vehicule_conducteur avc
WHERE v.id_vehicule = avc.id_vehicule
AND avc.id_conducteur = c.id_conducteur
AND v.modele = '807';

+----------+
| prenom   |
+----------+
| Julien   |
| Philippe |
+----------+

-- 3- Combien de véhicules a conduit Philippe?
SELECT COUNT(avc.id_conducteur) as'nbr_vehicule_conduit'
FROM conducteur c, association_vehicule_conducteur avc
WHERE avc.id_conducteur = c.id_conducteur
AND c.prenom = 'philippe';

+--------------------------+
|  nbr_vehicule_conduit    |
+--------------------------+
|                        2 |
+--------------------------+

-- 4- Qui ne conduit pas de véhicule?
SELECT prenom 
FROM conducteur
WHERE id_conducteur NOT IN (
	SELECT id_conducteur 
	FROM association_vehicule_conducteur);
	
+--------+
| prenom |
+--------+
| Alex   |
+--------+

-- 5- Quel véhicule n'a pas de chauffeur?
SELECT marque, modele 
FROM vehicule
WHERE id_vehicule NOT IN(
	SELECT id_vehicule 
	FROM association_vehicule_conducteur avc);

+------------+---------+
| marque     | modele  |
+------------+---------+
| Skoda      | Octavia |
| Volkswagen | Passat  |
+------------+---------+
	
-- 6- Qui conduit quoi?
SELECT c.prenom, v.marque, v.modele
FROM vehicule v, conducteur c, association_vehicule_conducteur avc
WHERE v.id_vehicule = avc.id_vehicule
AND avc.id_conducteur = c.id_conducteur;

SELECT c.prenom, v.marque, v.modele
FROM conducteur c
INNER JOIN association_vehicule_conducteur avc
ON avc.id_conducteur = c.id_conducteur
INNER JOIN vehicule v
ON v.id_vehicule = avc.id_vehicule;

+----------+------------+--------+
| prenom   | marque     | modele |
+----------+------------+--------+
| Julien   | Peugeot    | 807    |
| Morgane  | Citroen    | C8     |
| Philippe | Mercedes   | Cls    |
| Philippe | Peugeot    | 807    |
| Amelie   | Volkswagen | Touran |
+----------+------------+--------+

-- 7- Ajoutez-vous à la liste de conducteurs. Afficher tous les conducteurs et leur véhicules (même les conducteurs qui ne conduisent pas)(avec LEFT JOIN et RIGHT JOIN)
INSERT INTO conducteur VALUES ('', 'Julie', 'Galland');

SELECT c.prenom, v.modele 
FROM conducteur c
LEFT JOIN association_vehicule_conducteur avc 
ON avc.id_conducteur = c.id_conducteur
LEFT JOIN vehicule v 
ON v.id_vehicule = avc.id_vehicule;
 
+----------+--------+
| prenom   | modele |
+----------+--------+
| Julien   | 807    |
| Morgane  | C8     |
| Philippe | Cls    |
| Philippe | 807    |
| Alex     | NULL   |
| Amelie   | Touran |
| Julie    | NULL   |
+----------+--------+

-- 8- Ajoutez une nouvelle voiture. Afficher tous les véhiculent et leurs conducteurs (même ceux qui n'ont pas de conducteur)(avec LEFT JOIN et RIGHT JOIN)
INSERT INTO vehicule (marque, modele) VALUES ('Opel', 'Zafira');

SELECT v.modele, c.prenom
FROM vehicule v
LEFT JOIN association_vehicule_conducteur avc
ON v.id_vehicule = avc.id_vehicule
LEFT JOIN conducteur c
ON avc.id_conducteur = c.id_conducteur;

SELECT v.modele, c.prenom
FROM conducteur c
RIGHT JOIN association_vehicule_conducteur avc
ON avc.id_conducteur = c.id_conducteur
RIGHT JOIN vehicule v
ON v.id_vehicule = avc.id_vehicule;

+---------+----------+
| modele  | prenom   |
+---------+----------+
| 807     | Julien   |
| 807     | Philippe |
| C8      | Morgane  |
| Cls     | Philippe |
| Touran  | Amelie   |
| Octavia | NULL     |
| Passat  | NULL     |
| Zafira  | NULL     |
+---------+----------+

-- 9- Afficher de manière exhaustive tous les véhicules et leur conducteur avec ou sans correspondance(utiliser UNION)
SELECT v.modele, c.prenom
FROM conducteur c
LEFT JOIN association_vehicule_conducteur avc 
ON avc.id_conducteur = c.id_conducteur
LEFT JOIN vehicule v 
ON v.id_vehicule = avc.id_vehicule
UNION
SELECT v.modele, c.prenom
FROM vehicule v
LEFT JOIN association_vehicule_conducteur avc
ON v.id_vehicule = avc.id_vehicule
LEFT JOIN conducteur c
ON avc.id_conducteur = c.id_conducteur;

-- ! Pour que ça marche il faut que les termes de SELECT soient DANS LE MEME ORDRE! 

+---------+----------+
| modele  | prenom   |
+---------+----------+
| 807     | Julien   |
| C8      | Morgane  |
| Cls     | Philippe |
| 807     | Philippe |
| NULL    | Alex     |
| Touran  | Amelie   |
| NULL    | Julie    |
| Octavia | NULL     |
| Passat  | NULL     |
| Zafira  | NULL     |
+---------+----------+















