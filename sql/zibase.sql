-- phpMyAdmin SQL Dump
-- version 3.4.11.1deb2
-- http://www.phpmyadmin.net
--
-- Client: localhost
-- Gérée: Lun 09 Septembre 2013 à2:09
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

--
-- Contenu de la table `detail`
--

-- --------------------------------------------------------

--
-- Structure de la table `elec_cout`
--

CREATE TABLE IF NOT EXISTS `elec_cout` (
  `date` date NOT NULL,
  `HC` float NOT NULL,
  `HP` float NOT NULL,
  `fixe` float NOT NULL,
  PRIMARY KEY (`date`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Contenu de la table `elec_cout`
--

INSERT INTO `elec_cout` (`date`, `HC`, `HP`, `fixe`) VALUES
('2013-07-25', 0.0926, 0.1352, 0.5716);

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
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=25 ;

-- --------------------------------------------------------

--
-- Structure de la table `protocol`
--

CREATE TABLE IF NOT EXISTS `protocol` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nom` varchar(255) NOT NULL,
  `zcode` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2 ;

--
-- Contenu de la table `protocol`
--

INSERT INTO `protocol` (`id`, `nom`, `zcode`) VALUES
(1, 'ZWAVE', '6');

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
  PRIMARY KEY (`nom`)
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
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=3 ;

--
-- Contenu de la table `users`
--

INSERT INTO `users` (`id`, `pseudo`, `pass`) VALUES
(1, 'Admin', sha('secret'));

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

