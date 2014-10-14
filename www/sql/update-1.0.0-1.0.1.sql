DELETE FROM `modules_accueil` WHERE `modules_accueil`.`id` = 30;
DELETE FROM `modules_accueil` WHERE `modules_accueil`.`id` = 24;
DELETE FROM `modules_accueil` WHERE `modules_accueil`.`id` = 23;
DELETE FROM `modules_accueil` WHERE `modules_accueil`.`id` = 29;

INSERT INTO `modules_accueil` (`id`, `url`, `libelle`, `type`) VALUES
(30, 'actionneur_graph_annee', 'Graphique annuel actioneur', 'actioneur'),
(31, 'actionneur_graph_mois', 'Graphique mensuel actioneur', 'actioneur'),
(32, 'actionneurs_tableau_global', 'Tableau global actioneurs', ''),
(33, 'actionneur_tableau_periph', 'Tableau actioneur', 'actioneur'),
(34, 'capteurs_tableau_global', 'Tableau global capteur', ''),
(35, 'freebox_call', 'Appels Freebox', ''),
(36, 'freebox_conn_status', 'Statue de connexion freebox', ''),
(37, 'freebox_dhcp_baux_dynamique', 'Liste des connexions DHCP Freebox', ''),
(38, 'luminosite_graph_annee', 'Graphique annuel de luminosite', 'luminosite'),
(39, 'luminosite_graph_mois', 'Graphique mensuel de luminosite', 'luminosite'),
(40, 'luminosite_tableau_global', 'Tableau global des luminosités', 'luminosite'),
(41, 'pellet_graph_annee', 'Graphique de consommation de pellet annuelle', ''),
(42, 'pellet_graph_mois', 'Graphique de consommation de pellet mensuel', ''),
(43, 'pellet_tableau_periph', 'Tableau global de consommation de pellet', ''),
(44, 'pluie_graph_annee', 'Graphique annuel de précipitation', ''),
(45, 'pluie_graph_global', 'Graphique global de précipitation', ''),
(46, 'pluie_graph_journee', 'Graphique journalier de précipitation', ''),
(47, 'pluie_graph_mois', 'Graphique mensuel de précipitation', ''),
(48, 'pluie_tableau_global', 'Tableau global de précipitation', ''),
(49, 'video', 'Camera', 'video');

ALTER TABLE  `modules` ADD  `ordre` INT NOT NULL;

ALTER TABLE  `peripheriques` ADD  `ordre` INT NOT NULL;

ALTER TABLE  `insertion` ADD  `ordre` INT NOT NULL;

ALTER TABLE `stickers` ADD `page` varchar(255) NOT NULL default 'plan';
ALTER TABLE `dynaText` ADD `page` varchar(255) NOT NULL default 'plan';

ALTER TABLE  `peripheriques` ADD  `conso` INT NOT NULL;

ALTER TABLE `scenarios` ADD `libelle` varchar(255) NOT NULL AFTER `nom`;

UPDATE `paramettres` SET `id` = '41' WHERE `paramettres`.`id` =39;
UPDATE `paramettres` SET `id` = '42' WHERE `paramettres`.`id` =40;
INSERT INTO `paramettres` (`id`, `libelle`, `value`, `type`) VALUES ('39', 'heure creuse 2 debut', '00:00', 'time');
INSERT INTO `paramettres` (`id`, `libelle`, `value`, `type`) VALUES ('40', 'heure creuse 2 fin', '00:00', 'time');

ALTER TABLE `plan` ADD `image` varchar(255) NOT NULL default '';