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

INSERT INTO `modules` (`id`, `libelle`, `actif`) VALUES
(12, 'iphone', 1);

