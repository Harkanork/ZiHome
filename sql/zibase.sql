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
-- Structure de la table `actioneurs`
--

CREATE TABLE IF NOT EXISTS `actioneurs` (
  `nom` varchar(255) COLLATE utf8_general_mysql500_ci NOT NULL,
  `id` varchar(255) CHARACTER SET latin1 NOT NULL,
  `type` varchar(255) CHARACTER SET latin1 NOT NULL DEFAULT 'on_off',
  `logo` varchar(255) CHARACTER SET latin1 NOT NULL,
  `protocol` varchar(255) CHARACTER SET latin1 NOT NULL,
  `id_plan` int(11) NOT NULL DEFAULT '-1',
  `left` int(11) NOT NULL DEFAULT '0',
  `top` int(11) NOT NULL DEFAULT '0',
  `icone` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`nom`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_mysql500_ci;

-- --------------------------------------------------------

--
-- Structure de la table `conso_electrique`
--

CREATE TABLE IF NOT EXISTS `conso_electrique` (
  `nom` varchar(255) NOT NULL,
  `id` varchar(255) NOT NULL,
  `logo` varchar(255) NOT NULL,
  `batterie` int(11) NOT NULL,
  `id_plan` int(11) NOT NULL DEFAULT '-1',
  `icone` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`nom`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Structure de la table `detail`
--

CREATE TABLE IF NOT EXISTS `detail` (
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
-- Structure de la table `journalier`
--

CREATE TABLE IF NOT EXISTS `journalier` (
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
-- Structure de la table `sonde_temperature`
--

CREATE TABLE IF NOT EXISTS `sonde_temperature` (
  `nom` varchar(255) NOT NULL,
  `id` varchar(255) NOT NULL,
  `logo` varchar(255) NOT NULL,
  `batterie` int(11) NOT NULL,
  `id_plan` int(11) NOT NULL DEFAULT '-1',
  `left` int(11) NOT NULL DEFAULT '0',
  `top` int(11) NOT NULL DEFAULT '0',
  `icone` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`nom`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

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
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

-- --------------------------------------------------------

--
-- Structure de la table `sonde_vent`
--

CREATE TABLE IF NOT EXISTS `sonde_vent` (
  `nom` varchar(255) NOT NULL,
  `id` varchar(255) NOT NULL,
  `logo` varchar(255) NOT NULL,
  `batterie` int(11) NOT NULL,
  `id_plan` int(11) NOT NULL DEFAULT '-1',
  `icone` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`nom`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Structure de la table `capteurs`
--

CREATE TABLE IF NOT EXISTS `capteurs` (
  `nom` varchar(255) COLLATE utf8_general_mysql500_ci NOT NULL,
  `id` varchar(255) CHARACTER SET latin1 NOT NULL,
  `logo` varchar(255) CHARACTER SET latin1 NOT NULL,
  `protocol` varchar(255) CHARACTER SET latin1 NOT NULL,
  `id_plan` int(11) NOT NULL DEFAULT '-1',
  `left` int(11) NOT NULL DEFAULT '0',
  `top` int(11) NOT NULL DEFAULT '0',
  `icone` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`nom`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_mysql500_ci;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

-- --------------------------------------------------------

--
-- Structure de la table `scenarios`
--

CREATE TABLE IF NOT EXISTS `scenarios` (
  `nom` varchar(255) COLLATE utf8_general_mysql500_ci NOT NULL,
  `id` varchar(255) CHARACTER SET latin1 NOT NULL,
  `logo` varchar(255) CHARACTER SET latin1 NOT NULL,
  `id_plan` int(11) NOT NULL DEFAULT '-1',
  `left` int(11) NOT NULL DEFAULT '0',
  `top` int(11) NOT NULL DEFAULT '0',
  `icone` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`nom`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_mysql500_ci;

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
-- Contenu de la table `modules`
--

INSERT INTO `modules` (`id`, `libelle`, `actif`) VALUES
(1, 'owl', 1),
(2, 'conso_elec', 1),
(3, 'temperature', 1),
(4, 'batterie', 1),
(5, 'plan', 1),
(6, 'thermostat', 1),
(7, 'calendrier', 1);

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

INSERT INTO `paramettres` (`id`, `libelle`, `value`) VALUES
(1, 'icones', '1');



