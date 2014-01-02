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
(20, 'scenario', 'Scenario', 'scenario');

