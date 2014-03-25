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

-- --------------------------------------------------------

ALTER TABLE `iphone` ADD `sleep_base` int(11) NOT NULL;

-- --------------------------------------------------------

ALTER TABLE `iphone` ADD `sleep_coef` int(11) NOT NULL;

-- --------------------------------------------------------

--
-- Structure de la table `android`
--

CREATE TABLE IF NOT EXISTS `android` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `apikey` varchar(255) NOT NULL,
  `MobileNetworkCode` int(11) NOT NULL,
  `carrier` varchar(255) NOT NULL,
  `cellId` int(11) NOT NULL,
  `locationAreaCode` int(11) NOT NULL,
  `sleep_base` int(11) NOT NULL,
  `sleep_coef` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Structure de la table `android_distances`
--

CREATE TABLE IF NOT EXISTS `android_distances` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_android` int(11) NOT NULL,
  `sonde` varchar(255) NOT NULL,
  `longitude` varchar(255) NOT NULL,
  `latitude` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

INSERT INTO `modules` (`id`, `libelle`, `actif`) VALUES
(13, 'android', 1);


-- --------------------------------------------------------

INSERT INTO `paramettres` (`id`, `libelle`, `value`, `type`) VALUES
(7, 'iphone_sleep_base', '60', 'number'),
(8, 'iphone_sleep_coef', '60', 'number'),
(9, 'android_sleep_base', '60', 'number'),
(10, 'android_sleep_coef', '60', 'number');

-- --------------------------------------------------------

ALTER TABLE `iphone`
  DROP `sleep_base`,
  DROP `sleep_coef`;

-- --------------------------------------------------------

ALTER TABLE `android`
  DROP `sleep_base`,
  DROP `sleep_coef`;

-- --------------------------------------------------------

ALTER TABLE `peripheriques` ADD `texte` boolean NOT NULL default false; 

-- --------------------------------------------------------

ALTER TABLE `insertion` ADD `libelle` varchar(255) NOT NULL; 
ALTER TABLE `insertion` ADD `public` boolean NOT NULL default true; 

-- --------------------------------------------------------

ALTER TABLE `stickers` ADD `width` int(11);
ALTER TABLE `stickers` ADD `height` int(11);

-- --------------------------------------------------------

INSERT INTO `paramettres` (`id`, `libelle`, `value`, `type`) VALUES
(11, 'Icone m&eacute;t&eacute;o', 'true', 'checkbox'),
(12, 'Icone m&eacute;t&eacute;o dossier', 'colorful', 'selectbox'),
(13, 'Icone m&eacute;t&eacute;o largeur', '60', 'number'),
(14, 'Icone m&eacute;t&eacute;o hauteur', '60', 'number'),
(15, 'Icone m&eacute;t&eacute;o droite', '10', 'number'),
(16, 'Icone m&eacute;t&eacute;o bas', '10', 'number');

-- --------------------------------------------------------

INSERT INTO `modules` (`id`, `libelle`, `actif`) VALUES
(14, 'luminosite', 1);

-- --------------------------------------------------------

INSERT INTO `modules` (`id`, `libelle`, `actif`) VALUES
(15, 'freebox', 1);

INSERT INTO `modules_accueil` (`id`, `url`, `libelle`, `type`) VALUES
(22, 'freebox_reboot', 'Freebox Reboot', ''),
(23, 'freebox_ring_on', 'Freebox Telephone sonne', ''),
(24, 'freebox_ring_off', 'Freebox Telephone stop sonne', ''),
(25, 'freebox_wifi_off', 'Freebox Wifi OFF', ''),
(26, 'freebox_wifi_on', 'Freebox Wifi ON', ''),
(27, 'freebox_wifi_status', 'Freebox Wifi Status', ''),
(28, 'freebox_firmware', 'Freebox version firmware', ''),
(29, 'freebox_uptime', 'Freebox uptime', ''),
(30, 'freebox_conn_config', 'Freebox Connexion Status', '');

-- --------------------------------------------------------

INSERT INTO `modules` (`id`, `libelle`, `actif`) VALUES
(16, 'consommable', 1);

CREATE TABLE IF NOT EXISTS `consommable` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `date` date NOT NULL,
  `quantite` int(11) NOT NULL,
  `prix` int(11) NOT NULL,
  `type` varchar(16) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=8 ;

-- --------------------------------------------------------

ALTER TABLE `peripheriques` ADD `erreur` int(11) default 0 NOT NULL;
ALTER TABLE `peripheriques` ADD `date_erreur` DATETIME NOT NULL;

-- --------------------------------------------------------

--
-- Structure de la table `dynaText`
--

CREATE TABLE IF NOT EXISTS `dynaText` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `libelle` varchar(255) NOT NULL,
  `font` varchar(255) NOT NULL,
  `color` varchar(255) NOT NULL,
  `size` int(11) NOT NULL,
  `bold` boolean NOT NULL default false, 
  `italic` boolean NOT NULL default false,
  `left` int(11) NOT NULL,
  `top` int(11) NOT NULL,
  `condition` varchar(1024) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

ALTER TABLE  `video` ADD  `adresse_internet` VARCHAR( 255 ) NOT NULL AFTER  `adresse`;

-- --------------------------------------------------------

INSERT INTO `paramettres` (`id`, `libelle`, `value`, `type`) VALUES
(17, 'refresh', '10', 'checkbox');

CREATE TABLE IF NOT EXISTS `refresh` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `value` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=11 ;

INSERT INTO `refresh` (`id`, `value`) VALUES
(1, 1),
(2, 2),
(3, 3),
(4, 5),
(5, 10),
(6, 15),
(7, 20),
(8, 30),
(9, 45),
(10, 60);

-- --------------------------------------------------------

ALTER TABLE  `peripheriques` ADD  `graphique` BOOLEAN NOT NULL AFTER  `top`;

-- --------------------------------------------------------

--
-- Structure de la table `pollution`
--

CREATE TABLE IF NOT EXISTS `pollution` (
  `date` DATE NOT NULL,
  `Indice` int(11) NOT NULL,
  `O3` int(11) NOT NULL,
  `NO2` int(11) NOT NULL,
  `PM10` int(11) NOT NULL,
  `SO2` int(11) NOT NULL,
  PRIMARY KEY (`date`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

INSERT INTO `paramettres` (`id`, `libelle`, `value`, `type`) VALUES
(18, 'Icone pollution', 'true', 'checkbox'),
(19, 'Icone pollution largeur', '60', 'number'),
(20, 'Icone pollution hauteur', '60', 'number'),
(21, 'Icone pollution droite', '100', 'number'),
(22, 'Icone pollution bas', '10', 'number');

-- --------------------------------------------------------
