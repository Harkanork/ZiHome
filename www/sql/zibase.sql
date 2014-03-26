-- phpMyAdmin SQL Dump
-- version 3.4.11.1deb2
-- http://www.phpmyadmin.net
--
-- Client: localhost
-- Gérée: Jeu 26 Septembre 2013 à9:52
-- Version du serveur: 5.5.31
-- Version de PHP: 5.4.4-14+deb7u2

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Base de donné: `zibase`
--

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

--
-- Structure de la table `consommable`
--

CREATE TABLE IF NOT EXISTS `consommable` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `date` date NOT NULL,
  `quantite` int(11) NOT NULL,
  `prix` int(11) NOT NULL,
  `type` varchar(16) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=8 ;

-- --------------------------------------------------------

--
-- Structure de la table `insertion`
--

CREATE TABLE IF NOT EXISTS `insertion` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `url` varchar(255) NOT NULL,
  `icone` varchar(255) NOT NULL,
  `libelle` varchar(255) NOT NULL,
  `public` boolean NOT NULL default true,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=3 ;

-- --------------------------------------------------------

--
-- Structure de la table `owl_detail`
--

CREATE TABLE IF NOT EXISTS `owl_detail` (
  `date` datetime NOT NULL,
  `chan1` float NOT NULL,
  `chan2` float NOT NULL,
  `chan3` float NOT NULL,
  `battery` varchar(16) NOT NULL,
  `cumul` float NOT NULL,
  PRIMARY KEY (`date`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Structure de la table `owl_journalier`
--

CREATE TABLE IF NOT EXISTS `owl_journalier` (
  `date` date NOT NULL,
  `chan1` float NOT NULL,
  `chan2` float NOT NULL,
  `chan3` float NOT NULL,
  `HC` float NOT NULL,
  `cout` float NOT NULL,
  PRIMARY KEY (`date`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Structure de la table `modules`
--

CREATE TABLE IF NOT EXISTS `modules` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `libelle` varchar(255) NOT NULL,
  `actif` tinyint(1) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Structure de la table `plan`
--

CREATE TABLE IF NOT EXISTS `plan` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `libelle` varchar(255) NOT NULL,
  `width` int(11) NOT NULL,
  `height` int(11) NOT NULL,
  `left` int(11) NOT NULL,
  `top` int(11) NOT NULL,
  `line-height` int(11) NOT NULL,
  `text-align` varchar(255) NOT NULL DEFAULT 'center',
  `border` varchar(255) NOT NULL DEFAULT '2',
  `popup` text NOT NULL,
  `supplementaire` varchar(255) NOT NULL,
  `show-libelle` boolean default true,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Structure de la table `protocol`
--

CREATE TABLE IF NOT EXISTS `protocol` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nom` varchar(255) NOT NULL,
  `zcode` varchar(255) NOT NULL,
  `actif` tinyint(1) NOT NULL DEFAULT '1',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Structure de la table `tarif_elec`
--

CREATE TABLE IF NOT EXISTS `tarif_elec` (
  `date` date NOT NULL,
  `HC` float NOT NULL,
  `HP` float NOT NULL,
  `fixe` float NOT NULL,
  PRIMARY KEY (`date`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Structure de la table `users`
--

CREATE TABLE IF NOT EXISTS `users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `pseudo` varchar(255) CHARACTER SET latin1 COLLATE latin1_bin NOT NULL,
  `pass` varchar(255) NOT NULL,
  `niveau` varchar(255) NOT NULL DEFAULT 'admin', 
  `css` varchar(255) NOT NULL,
  `accueil` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Structure de la table `scenarios`
--

CREATE TABLE IF NOT EXISTS `scenarios` (
  `nom` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `id` varchar(255) CHARACTER SET latin1 NOT NULL,
  `logo` varchar(255) CHARACTER SET latin1 NOT NULL,
  `id_plan` int(11) NOT NULL DEFAULT '-1',
  `left` int(11) NOT NULL DEFAULT '0',
  `top` int(11) NOT NULL DEFAULT '0',
  `icone` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`nom`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Structure de la table `iphone`
--

CREATE TABLE IF NOT EXISTS `iphone` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `periph_name` varchar(255) NOT NULL,
  `user` varchar(255) NOT NULL,
  `pass` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Structure de la table `iphone_distances`
--

CREATE TABLE IF NOT EXISTS `iphone_distances` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `id_iphone` int(11) NOT NULL,
  `sonde` varchar(255) NOT NULL,
  `longitude` varchar(255) NOT NULL,
  `latitude` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

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

--
-- Structure de la table `peripheriques`
--

CREATE TABLE IF NOT EXISTS `peripheriques` (
  `periph` varchar(255) CHARACTER SET latin1 NOT NULL,
  `nom` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `id` varchar(255) CHARACTER SET latin1 NOT NULL,
  `type` varchar(255) CHARACTER SET latin1 NOT NULL DEFAULT 'on_off',
  `logo` varchar(255) CHARACTER SET latin1 NOT NULL,
  `protocol` varchar(255) CHARACTER SET latin1 NOT NULL,
  `batterie` int(11) NOT NULL,
  `id_plan` int(11) NOT NULL DEFAULT '-1',
  `left` int(11) NOT NULL DEFAULT '0',
  `top` int(11) NOT NULL DEFAULT '0',
  `graphique` tinyint(1) NOT NULL DEFAULT '1',
  `icone` int(11) NOT NULL DEFAULT '0',
  `gerer_batterie` VARCHAR( 255 ) NOT NULL ,
  `date_chgt_batterie` DATE NOT NULL ,
  `libelle` VARCHAR( 255 ) NOT NULL ,
  `alerte_batterie` DATETIME NOT NULL ,
  `show_value2` BOOLEAN NOT NULL DEFAULT FALSE,
  `texte` BOOLEAN NOT NULL DEFAULT FALSE,
  `erreur` int(11) default 0 NOT NULL,
  `date_erreur` DATETIME NOT NULL ,
  PRIMARY KEY (`nom`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Structure de la table `message_zibase`
--

CREATE TABLE IF NOT EXISTS `message_zibase` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `date` datetime NOT NULL,
  `message` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

-- --------------------------------------------------------

--
-- Structure de la table `paramettres`
--

CREATE TABLE IF NOT EXISTS `paramettres` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `libelle` varchar(255) NOT NULL,
  `value` varchar(255) NOT NULL,
  `type` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Structure de la table `auto-logon`
--

CREATE TABLE IF NOT EXISTS `auto-logon` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `pseudo` varchar(255) NOT NULL,
  `macaddress` varchar(255) NOT NULL,
  `description` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Structure de la table `variables`
--

CREATE TABLE IF NOT EXISTS `variables` (
  `id` int(11) NOT NULL,
  `description` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Structure de la table `css`
--

CREATE TABLE IF NOT EXISTS `css` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `value` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2 ;

-- --------------------------------------------------------

--
-- Structure de la table `page_accueil`
--

CREATE TABLE IF NOT EXISTS `page_accueil` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `libelle` varchar(255) NOT NULL,
  `user` varchar(255) NOT NULL,
  `width` int(11) NOT NULL,
  `height` int(11) NOT NULL,
  `left` int(11) NOT NULL,
  `top` int(11) NOT NULL,
  `graphique` tinyint(1) NOT NULL,
  `border` int(11) NOT NULL,
  `url` varchar(255) NOT NULL,
  `peripherique` varchar(255) NOT NULL,
  `option` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Structure de la table `modules_accueil`
--

CREATE TABLE IF NOT EXISTS `modules_accueil` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `url` varchar(255) NOT NULL,
  `libelle` varchar(255) NOT NULL,
  `type` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=21 ;

-- --------------------------------------------------------

--
-- Structure de la table `stickers`
--

CREATE TABLE IF NOT EXISTS `stickers` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `libelle` varchar(255) NOT NULL,
  `fichier` varchar(255) NOT NULL,
  `left` int(11) NOT NULL,
  `top` int(11) NOT NULL,
  `width` int(11),
  `height` int(11),
  `condition` varchar(1024) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Structure de la table `video`
--

CREATE TABLE IF NOT EXISTS `video` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `adresse` varchar(255) NOT NULL,
  `adresse_internet` varchar(255) NOT NULL,
  `id_plan` int(11) NOT NULL,
  `option` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Structure de la table `refresh`
--

CREATE TABLE IF NOT EXISTS `refresh` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `value` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=11 ;

-- --------------------------------------------------------

--
-- Contenu de la table `refresh`
--

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

-- --------------------------------------------------------

--
-- Contenu de la table `modules_accueil`
--

INSERT INTO `modules_accueil` (`id`, `url`, `libelle`, `type`) VALUES
(1, 'batterie', 'Batterie', ''),
(2, 'conso_elec_tableau_global', 'Tableau de consomation electrique global', ''),
(3, 'owl_global', 'Graphique quotidien OWL', ''),
(4, 'temperature_graph_jour', 'Graphique journalier de temperature', 'temperature'),
(5, 'vent_graph_rosedesvents', 'Rose des vents', 'vent'),
(6, 'conso_elec_graph_annee', 'Graphique consomation electrique annuelle', 'conso'),
(7, 'conso_elec_tableau_periph', 'Tableau consomation electrique', ''),
(8, 'owl_phases_graph', 'Consomation electrique par phase OWL', ''),
(9, 'temperature_graph_mois', 'Graphique temperature mensuelle', 'temperature'),
(10, 'vent_tableau_global', 'Tableau vent', ''),
(11, 'conso_elec_graph_journee', 'Graphique consomation electrique journaliere', 'conso'),
(12, 'owl_batterie', 'Batterie OWL', 'owl'),
(13, 'owl_tableau_global', 'Tableau OWL global', ''),
(14, 'temperature_tableau_global', 'Tableau temperature global', ''),
(15, 'conso_elec_graph_mois', 'Graphique consomation electrique mensuelle', 'conso'),
(16, 'owl_global_month', 'Graphique consomation electrique mensuelle OWL', ''),
(17, 'temperature_graph_annee', 'Graphique temperature annuelle', 'temperature'),
(18, 'vent_graph_jour', 'Graphique vent journalier', 'vent'),
(19, 'actioneur', 'Actioneur', 'actioneur'),
(20, 'scenario', 'Scenario', 'scenario'),
(21, 'luminosite_graph_jour', 'Graphique journalier de luminosite', 'luminosite'),
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

--
-- Contenu de la table `css`
--

INSERT INTO `css` (`id`, `value`) VALUES
(1, 'style');

-- --------------------------------------------------------
--
-- Contenu de la table `variables`
--

INSERT INTO `variables` (`id`, `description`) VALUES
(0, ''),
(1, ''),
(2, ''),
(3, ''),
(4, ''),
(5, ''),
(6, ''),
(7, ''),
(8, ''),
(9, ''),
(10, ''),
(11, ''),
(12, ''),
(13, ''),
(14, ''),
(15, ''),
(16, ''),
(17, ''),
(18, ''),
(19, ''),
(20, ''),
(21, ''),
(22, ''),
(23, ''),
(24, ''),
(25, ''),
(26, ''),
(27, ''),
(28, ''),
(29, ''),
(30, ''),
(31, ''),
(32, ''),
(33, ''),
(34, ''),
(35, ''),
(36, ''),
(37, ''),
(38, ''),
(39, ''),
(40, ''),
(41, ''),
(42, ''),
(43, ''),
(44, ''),
(45, ''),
(46, ''),
(47, ''),
(48, ''),
(49, ''),
(50, ''),
(51, ''),
(52, ''),
(53, ''),
(54, ''),
(55, ''),
(56, ''),
(57, ''),
(58, ''),
(59, '');

-- --------------------------------------------------------

--
-- Contenu de la table `modules`
--

INSERT INTO `modules` (`id`, `libelle`, `actif`) VALUES
(1, 'owl', 1),
(2, 'conso_elec', 1),
(3, 'temperature', 1),
(4, 'batterie', 1),
(5, 'plan', 1),
(6, 'thermostat', 1),
(7, 'calendrier', 1),
(8, 'vent', 1),
(9, 'accueil', 1),
(10, 'pluie', 1),
(11, 'video', 1),
(12, 'iphone', 1),
(13, 'android', 1),
(14, 'luminosite', 1),
(15, 'freebox', 1),
(16, 'consommable', 1);

-- --------------------------------------------------------

--
-- Contenu de la table `protocol`
--

INSERT INTO `protocol` (`id`, `nom`, `zcode`) VALUES
(1, 'ZWAVE', '6'),
(2, 'PRESET', '0'),
(3, 'VISONIC433', '1'),
(4, 'VISONIC868', '2'),
(5, 'CHACON', '3'),
(6, 'DOMIA', '4'),
(7, 'X10', '5'),
(8, 'RFS10', '7'),
(9, 'X2D433', '8'),
(10, 'X2D433ALRM', '8'),
(11, 'X2D868', '9'),
(12, 'X2D868ALRM', '9'),
(13, 'X2D868INSH', '10'),
(14, 'X2D868PIWI', '11'),
(15, 'X2D868BOAC', '12');

-- --------------------------------------------------------

--
-- Contenu de la table `tarif_elec`
--

INSERT INTO `tarif_elec` (`date`, `HC`, `HP`, `fixe`) VALUES
('2013-07-25', 0.0926, 0.1352, 0.5716),
('2013-08-09', 0.1002, 0.1467, 1.7368);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

-- --------------------------------------------------------

--
-- Contenu de la table `users`
--

INSERT INTO `users` (`id`, `pseudo`, `pass`) VALUES
(1, 'Admin', sha('secret'));

-- --------------------------------------------------------

--
-- Contenu de la table `paramettres`
--

INSERT INTO `paramettres` (`id`, `libelle`, `value`, `type`) VALUES
(1, 'icones', '1', 'selectbox'),
(2, 'css', 'style', 'selectbox'),
(3, 'accueil', 'plan', 'selectbox'),
(4, 'largeur icones', '60', 'number'),
(5, 'hauteur icones', '60', 'number'),
(6, 'afficher le nom des pi&egrave;ces', 'true', 'checkbox'),
(7, 'iphone_sleep_base', '60', 'number'),
(8, 'iphone_sleep_coef', '60', 'number'),
(9, 'android_sleep_base', '60', 'number'),
(10, 'android_sleep_coef', '60', 'number'),
(11, 'Icone m&eacute;t&eacute;o', 'true', 'checkbox'),
(12, 'Icone m&eacute;t&eacute;o dossier', 'colorful', 'selectbox'),
(13, 'Icone m&eacute;t&eacute;o largeur', '60', 'number'),
(14, 'Icone m&eacute;t&eacute;o hauteur', '60', 'number'),
(15, 'Icone m&eacute;t&eacute;o droite', '10', 'number'),
(16, 'Icone m&eacute;t&eacute;o bas', '10', 'number'),
(17, 'refresh', '10', 'selectbox'),
(18, 'Icone pollution', 'true', 'checkbox'),
(19, 'Icone pollution largeur', '60', 'number'),
(20, 'Icone pollution hauteur', '60', 'number'),
(21, 'Icone pollution droite', '100', 'number'),
(22, 'Icone pollution bas', '10', 'number');


CREATE VIEW accueil AS SELECT id AS id, libelle AS value FROM modules WHERE actif = '1';


