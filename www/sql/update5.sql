-- --------------------------------------------------------

INSERT INTO `paramettres` (`id`, `libelle`, `value`) VALUES
(4, 'largeur icones', '60');
INSERT INTO `paramettres` (`id`, `libelle`, `value`) VALUES
(5, 'hauteur icones', '60');

-- --------------------------------------------------------

ALTER TABLE `paramettres` ADD `type` VARCHAR( 255 ) NOT NULL ;

-- --------------------------------------------------------

UPDATE `paramettres` SET `type`='selectbox' WHERE libelle='icones' or libelle='css' or libelle='accueil';
UPDATE `paramettres` SET `type`='number' WHERE libelle='largeur icones' or libelle='hauteur icones';

-- --------------------------------------------------------

INSERT INTO `paramettres` (`id`, `libelle`, `value`, `type`) VALUES
(6, 'afficher le nom des pi&egrave;ces', 'true', 'checkbox');

-- --------------------------------------------------------

ALTER TABLE `plan` ADD `show-libelle` boolean default true ;

-- --------------------------------------------------------

ALTER TABLE `peripheriques` ADD `alerte_batterie` DATETIME NOT NULL;

-- --------------------------------------------------------

ALTER TABLE `peripheriques` ADD `show_value2` boolean NOT NULL default false; 

--
-- Structure de la table `stickers`
--

CREATE TABLE IF NOT EXISTS `stickers` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `libelle` varchar(255) NOT NULL,
  `fichier` varchar(255) NOT NULL,
  `left` int(11) NOT NULL,
  `top` int(11) NOT NULL,
  `condition` varchar(1024) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

