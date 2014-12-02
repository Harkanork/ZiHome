UPDATE `modules_accueil` SET `url` = 'conso_elec_graph_conso_cout',
`libelle` = 'Graphique historique consommation et cout' WHERE `modules_accueil`.`id` =6;

UPDATE `modules_accueil` SET `url` = 'conso_elec_graph_puissance',
`libelle` = 'Graphique historique puissance elec' WHERE `modules_accueil`.`id` =11;

DELETE FROM `modules_accueil` WHERE `modules_accueil`.`id` = 15;