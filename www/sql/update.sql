ALTER TABLE `users` ADD `niveau` VARCHAR( 255 ) NOT NULL DEFAULT 'admin';

-- --------------------------------------------------------

--
-- Structure de la table `insertion`
--

CREATE TABLE IF NOT EXISTS `insertion` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `url` varchar(255) NOT NULL,
  `icone` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=3 ;


