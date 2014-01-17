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

