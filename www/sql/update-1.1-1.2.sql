UPDATE `modules_accueil` SET `url` = 'conso_elec_graph_conso_cout',
`libelle` = 'Graphique historique consommation et cout' WHERE `modules_accueil`.`id` =6;

UPDATE `modules_accueil` SET `url` = 'conso_elec_graph_puissance',
`libelle` = 'Graphique historique puissance elec' WHERE `modules_accueil`.`id` =11;

DELETE FROM `modules_accueil` WHERE `modules_accueil`.`id` = 15;


-- --------------------------------------------------------

--
-- Structure de la table `notes`
--

CREATE TABLE IF NOT EXISTS `notes` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `text` text COLLATE utf8_unicode_ci NOT NULL,
  `x` int(10) NOT NULL,
  `y` int(10) NOT NULL,
  `z` int(10) NOT NULL,
  `w` int(10) NOT NULL,
  PRIMARY KEY (`id`)
) ;

--
-- Contenu de la table `notes`
--

INSERT INTO `notes` (`id`, `text`, `x`, `y`, `z`, `w`) VALUES
(1, 'Vous pouvez me déplacer, m''élargir, me modifier, ou me supprimer !', 200, 200, 1, 200);


--
-- Ajout du module
--

INSERT INTO `modules` (`id` , `libelle` , `actif` , `ordre` ) VALUES ('19', 'notes', '1', '0');

