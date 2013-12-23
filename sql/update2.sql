-- --------------------------------------------------------

--
-- Structure de la table `css`
--

CREATE TABLE IF NOT EXISTS `css` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `value` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2 ;

--
-- Contenu de la table `css`
--

INSERT INTO `css` (`id`, `value`) VALUES
(1, 'style');

-- --------------------------------------------------------

--
-- Contenu de la table `paramettres`
--

INSERT INTO `paramettres` (`id`, `libelle`, `value`) VALUES
(2, 'css', 'style');

ALTER TABLE `users` ADD `css` VARCHAR( 255 ) NOT NULL ;

