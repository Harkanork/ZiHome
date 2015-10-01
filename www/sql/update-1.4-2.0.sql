


--
-- Création de la table menu pour gérer dynamiquement l'ordre des éléments du bandeau
--

CREATE TABLE IF NOT EXISTS `menu` (
  `id` int(1) NOT NULL AUTO_INCREMENT,
  `type` varchar(50) NOT NULL,
  `module_id` int(1) NOT NULL,
  `libelle` varchar(50) NOT NULL,
  `icone` varchar(50) NOT NULL,
  `ordre` int(1) NOT NULL,
  `auth` int(1) NOT NULL DEFAULT '0',
  `url` varchar(900) NOT NULL,
  PRIMARY KEY (`id`)
) ;

--
-- On récupère les modules actuels (seulement ceux activés), dans le même ordre, et on précise un libellé pour le menu associé
-- 
INSERT INTO `menu` (module_id, ordre) SELECT id, ordre FROM `modules` WHERE actif=1 ORDER BY ordre ASC ;
UPDATE `menu` SET type='module' WHERE 1;
UPDATE `menu` SET libelle = 'Conso-Elec', icone = 'icon_elec.png' WHERE module_id = ( SELECT `id` FROM `modules` WHERE `libelle` = 'conso_elec' );
UPDATE `menu` SET libelle = 'Temp&eacute;rature', icone ='icon_temp.png' WHERE module_id = ( SELECT `id` FROM `modules` WHERE `libelle` = 'temperature' );
UPDATE `menu` SET libelle = 'Luminosit&eacute;', icone ='icon_lum.png' WHERE module_id = ( SELECT `id` FROM `modules` WHERE `libelle` = 'luminosite' );
UPDATE `menu` SET libelle = 'OWL', icone ='icon_elec.png' WHERE module_id = ( SELECT `id` FROM `modules` WHERE `libelle` = 'owl' );
UPDATE `menu` SET libelle = 'Batteries', icone ='icon_pile.png' WHERE module_id = ( SELECT `id` FROM `modules` WHERE `libelle` = 'batterie' );
UPDATE `menu` SET libelle = 'Plan', icone ='icon_home.png' WHERE module_id = ( SELECT `id` FROM `modules` WHERE `libelle` = 'plan' );
UPDATE `menu` SET libelle = 'Actionneurs', icone ='icon_home.png' WHERE module_id = ( SELECT `id` FROM `modules` WHERE `libelle` = 'actionneurs' );
UPDATE `menu` SET libelle = 'Thermostat', icone ='icon_temp.png', auth=1 WHERE module_id = ( SELECT `id` FROM `modules` WHERE `libelle` = 'thermostat' );
UPDATE `menu` SET libelle = 'Calendrier', icone ='icon_calendrier.png', auth=1 WHERE module_id = ( SELECT `id` FROM `modules` WHERE `libelle` = 'calendrier' );
UPDATE `menu` SET libelle = 'Vent', icone ='icon_vent.png' WHERE module_id = ( SELECT `id` FROM `modules` WHERE `libelle` = 'vent' );
UPDATE `menu` SET libelle = 'Pellet', icone ='icon_home.png' WHERE module_id = ( SELECT `id` FROM `modules` WHERE `libelle` = 'pellet' );
UPDATE `menu` SET libelle = 'Accueil', icone ='icon_home.png' WHERE module_id = ( SELECT `id` FROM `modules` WHERE `libelle` = 'accueil' );
UPDATE `menu` SET libelle = 'Pluie', icone ='icon_pluie.png' WHERE module_id = ( SELECT `id` FROM `modules` WHERE `libelle` = 'pluie' );
UPDATE `menu` SET libelle = 'Cam&eacute;ras', icone ='icon_video.png', auth=1 WHERE module_id = ( SELECT `id` FROM `modules` WHERE `libelle` = 'video' );
UPDATE `menu` SET libelle = 'Consommables', icone ='icon_elec.png', auth=1 WHERE module_id = ( SELECT `id` FROM `modules` WHERE `libelle` = 'consommable' );
UPDATE `menu` SET libelle = 'Freebox', icone ='icon_home.png', auth=1 WHERE module_id = ( SELECT `id` FROM `modules` WHERE `libelle` = 'freebox' );
UPDATE `menu` SET libelle = 'Notes', icone ='icon_notes.png', auth=1 WHERE module_id = ( SELECT `id` FROM `modules` WHERE `libelle` = 'notes' );
UPDATE `menu` SET libelle = 'IPhone', icone ='icon_iphone.png', auth=1 WHERE module_id = ( SELECT `id` FROM `modules` WHERE `libelle` = 'iphone' );
UPDATE `menu` SET libelle = 'Android', icone ='icon_apps.png', auth=1 WHERE module_id = ( SELECT `id` FROM `modules` WHERE `libelle` = 'android' );
UPDATE `menu` SET libelle = 'Conso eau', icone ='icon_eau.png', auth=1 WHERE module_id = ( SELECT `id` FROM `modules` WHERE `libelle` = 'conso_eau' );

--
-- On récupère les pages supplémentaires insérées, leur libellé, et on les ajoute à la suite des menus précédents
-- 
INSERT INTO `menu` (module_id, libelle, icone, auth, url) SELECT id, libelle, icone, -public, url FROM `insertion` WHERE 1 ORDER BY ordre ASC ; -- Remarque : le "-" devant public permet d'attribuer -1 ou 0 pour les droits, la ligne suivante ajoute 1 et on retombe ainsi sur nos pattes (0 ou 1 inversé par rapport à la table d'origine)
UPDATE `menu`SET type='interne', auth=auth+1 WHERE `type` = '';
UPDATE `menu` SET ordre= (SELECT COUNT(*) FROM (SELECT * FROM `menu`) as x WHERE `ordre` IS NOT NULL) WHERE `type`='interne' ORDER BY `ordre` ASC; -- place les plages supp. en fin de menu, requete bizarre pour contourner un bug de mysql (requetes imbriquées sur la même table)

--
-- La table insertion ne servira plus, toutes les infos sont intégrées dans la table menu, on la supprime donc
--
DROP TABLE `insertion`;

--
-- Pour les modules, on supprime les colonnes inutiles, et on distingue le libelle (= nom affiché dans les menus déroulants), de l'url (= nom du fichier)
--
ALTER TABLE `modules` DROP `ordre`;
ALTER TABLE `modules` ADD `url` VARCHAR( 50 ) NOT NULL ;
UPDATE `modules` SET url = libelle, libelle = 'Donn&eacute;es conso &eacute;lec' WHERE `libelle` = 'conso_elec';
UPDATE `modules` SET url = libelle, libelle = 'Donn&eacute;es temp&eacute;rature' WHERE `libelle` = 'temperature';
UPDATE `modules` SET url = libelle, libelle = 'Donn&eacute;es luminosit&eacute;'WHERE `libelle` = 'luminosite';
UPDATE `modules` SET url = libelle, libelle = 'Donn&eacute;es conso OWL'WHERE `libelle` = 'owl';
UPDATE `modules` SET url = libelle, libelle = 'Etat des batteries'WHERE `libelle` = 'batterie';
UPDATE `modules` SET url = libelle, libelle = 'Plan - Bientot obsolete'WHERE `libelle` = 'plan';
UPDATE `modules` SET url = libelle, libelle = 'Bilan des actionneurs'WHERE `libelle` = 'actionneurs';
UPDATE `modules` SET url = libelle, libelle = 'Module thermostat'WHERE `libelle` = 'thermostat';
UPDATE `modules` SET url = libelle, libelle = 'Module calendrier'WHERE `libelle` = 'calendrier';
UPDATE `modules` SET url = libelle, libelle = 'Donn&eacute;es an&eacute;mom&eacute;trie'WHERE `libelle` = 'vent';
UPDATE `modules` SET url = libelle, libelle = 'Donn&eacute;es conso pellet'WHERE `libelle` = 'pellet';
UPDATE `modules` SET url = libelle, libelle = 'Accueil - Bientot obsolete'WHERE `libelle` = 'accueil';
UPDATE `modules` SET url = libelle, libelle = 'Donn&eacute;es pluviom&eacute;trie'WHERE `libelle` = 'pluie';
UPDATE `modules` SET url = libelle, libelle = 'Affichage des cam&eacute;ras'WHERE `libelle` = 'video';
UPDATE `modules` SET url = libelle, libelle = 'Gestion des consommables'WHERE `libelle` = 'consommable';
UPDATE `modules` SET url = libelle, libelle = 'Module Freebox'WHERE `libelle` = 'freebox';
UPDATE `modules` SET url = libelle, libelle = 'Tableau virtuel &#40;notes&#41;'WHERE `libelle` = 'notes';
UPDATE `modules` SET url = libelle, libelle = 'Module Iphone'WHERE `libelle` = 'iphone';
UPDATE `modules` SET url = libelle, libelle = 'Module Android'WHERE `libelle` = 'android';
UPDATE `modules` SET url = libelle, libelle = 'Donn&eacute;es conso OWL'WHERE `libelle` = 'conso_eau';


--
-- On crée la table vues qui va permettre de personnaliser et multiplier les pages de type accueil ou plan, et mélanger les pièces, stickers, textes dynamiques
--

CREATE TABLE IF NOT EXISTS `vues` (
  `id` int(1) NOT NULL AUTO_INCREMENT,
  `libelle` varchar(50) NOT NULL,
  PRIMARY KEY (`id`)
) ;

--
-- On créé la table vues_elements qui contiendra toutes les infos d'affichages, pour ça on récupère les infos de page_accueil et on modifie un peu la structure
--
RENAME TABLE `page_accueil` TO `vues_elements`;
ALTER TABLE `vues_elements` ADD `vue_id` INT( 1 ) NOT NULL AFTER `id` ; -- on précise pour chaque élément sur quelle vue il doit être affiché
ALTER TABLE `vues_elements` ADD `font` VARCHAR( 255 ) NOT NULL AFTER `top` ; -- on l'adapte pour pouvoir y insérer aussi les textes dynamiques et stickers
ALTER TABLE `vues_elements` ADD `color` VARCHAR( 255 ) NOT NULL AFTER `font` ;
ALTER TABLE `vues_elements` ADD `size` INT( 1 ) NOT NULL AFTER `color` ;
ALTER TABLE `vues_elements` ADD `bold` INT( 1 ) NOT NULL AFTER `size` ;
ALTER TABLE `vues_elements` ADD `italic` INT( 1 ) NOT NULL AFTER `bold` ;
ALTER TABLE `vues_elements` ADD `fichier` VARCHAR( 255 ) NOT NULL AFTER `italic` ;
ALTER TABLE `vues_elements` ADD `condition` VARCHAR( 1024 ) NOT NULL AFTER `fichier` ;
ALTER TABLE `vues_elements` ADD `type` VARCHAR(50) NOT NULL;
ALTER TABLE `vues_elements` ADD `affich_libelle` INT( 1 ) NOT NULL DEFAULT '0' AFTER `border` ;
UPDATE `vues_elements` SET `type`='fonction' WHERE 1=1;

--
-- On créé la vue accueil pour remplacer le module accueil en toute transparence, et on met à jour le menu pour renvoyer vers cette vue plutôt que le module accueil
-- 
INSERT INTO `vues`(`libelle`) VALUES ('accueil');
UPDATE `menu` SET `type`='vue', `module_id`=(SELECT `id` FROM `vues` WHERE `libelle`='accueil') WHERE `libelle`='Accueil';

--
-- On attribue tout ce qu'on a récupérer sur page_accueil à cette nouvelle vue, et on y ajoute également les textes dynamiques et stickers qui étaient destinés à la page d'accueil
--
UPDATE `vues_elements` SET `vue_id`=(SELECT `id` FROM `vues` WHERE `libelle`='accueil') WHERE 1=1;
INSERT INTO `vues_elements`(`type`, `libelle`, `font`, `color`, `size`, `bold`, `italic`, `left`, `top`, `condition`, `vue_id`) SELECT 'textdyn', `dynatext`.`libelle`, `dynatext`.`font`, `dynatext`.`color`, `dynatext`.`size`, `dynatext`.`bold`, `dynatext`.`italic`, `dynatext`.`left`, `dynatext`.`top`, `dynatext`.`condition`, `vues`.`id` FROM `dynatext`, `vues` WHERE `dynatext`.`page`='accueil' AND `vues`.`libelle`='accueil';
INSERT INTO `vues_elements`(`type`, `libelle`, `left`, `top`, `width`, `height`, `condition`, `url`, `vue_id`) SELECT 'sticker', `stickers`.`libelle`, `stickers`.`left`, `stickers`.`top`, `stickers`.`width`, `stickers`.`height`, `stickers`.`condition`, `stickers`.`fichier`, `vues`.`id` FROM `stickers`, `vues` WHERE `stickers`.`page`='accueil' AND `vues`.`libelle`='accueil';


--
-- On créé la vue plan pour remplacer le module plan en toute transparence, on met à jour le menu, et on y ajouter les textes dynamiques et stickers correspondant
--
INSERT INTO `vues`(`libelle`) VALUES ('plan');
UPDATE `menu` SET `type`='vue', `module_id`=(SELECT `id` FROM `vues` WHERE `libelle`='plan') WHERE `libelle`='Plan';
INSERT INTO `vues_elements`(`type`, `libelle`, `font`, `color`, `size`, `bold`, `italic`, `left`, `top`, `condition`, `vue_id`) SELECT 'textdyn', `dynatext`.`libelle`, `dynatext`.`font`, `dynatext`.`color`, `dynatext`.`size`, `dynatext`.`bold`, `dynatext`.`italic`, `dynatext`.`left`, `dynatext`.`top`, `dynatext`.`condition`, `vues`.`id` FROM `dynatext`, `vues` WHERE `dynatext`.`page`='plan' AND `vues`.`libelle`='plan';
INSERT INTO `vues_elements`(`type`, `libelle`, `left`, `top`, `width`, `height`, `condition`, `url`, `vue_id`) SELECT 'sticker', `stickers`.`libelle`, `stickers`.`left`, `stickers`.`top`, `stickers`.`width`, `stickers`.`height`, `stickers`.`condition`, `stickers`.`fichier`, `vues`.`id` FROM `stickers`, `vues` WHERE `stickers`.`page`='plan' AND `vues`.`libelle`='plan';

--
-- On récupère, si activé dans les paramètres, l'icone pollution pour la positionner comme un élément de cette vue
--
INSERT INTO `vues_elements`(`type`, `vue_id`) SELECT 'pollution', v.`id` FROM `paramettres` p, `vues` v WHERE p.`id`='18' AND p.`value`='true' AND v.`libelle`='plan';
UPDATE `vues_elements` SET `width`=(SELECT `value` FROM `paramettres` WHERE `id`='19'), `height`=(SELECT `value` FROM `paramettres` WHERE `id`='20'), `left`=(SELECT `value` FROM `paramettres` WHERE `id`='21'), `top`=(SELECT `value` FROM `paramettres` WHERE `id`='22') WHERE `type`='pollution';

--
-- On ajoute à cette vue les autres éléments qui y étaient affichés : des cadres correspondant aux pièces avec leur fond d'écran, les actionneurs et les capteurs (le reste ne peut actuellement pas être affiché sur le plan, on le récupère après pour les rapports) 
--
INSERT INTO `vues_elements`(`type`, `libelle`, `left`, `top`, `width`, `height`, `border`, `affich_libelle`, `url`, `option`, `vue_id`) SELECT 'cadre', `plan`.`libelle`, `plan`.`left`, `plan`.`top`, `plan`.`width`, `plan`.`height`, `plan`.`border`, `plan`.`show-libelle`, `plan`.`image`, `plan`.`supplementaire`, `vues`.`id` FROM `plan`, `vues` WHERE `vues`.`libelle`='plan';
INSERT INTO `vues_elements`(`type`, `peripherique`, `libelle`, `left`, `top`, `affich_libelle`, `url`, `vue_id`) SELECT pe.`periph`, pe.`id`, pe.`libelle`, pe.`left` + pl.`left`, pe.`top` + pl.`top`, pe.`texte`, pe.`logo`, v.`id` FROM `peripheriques` pe, `plan` pl, `vues` v WHERE pe.`icone`=1 AND pe.`id_plan`>=0 AND pe.`libelle` !='' AND pl.`id` = pe.`id_plan` AND v.`libelle`='plan';
INSERT INTO `vues_elements`(`type`, `peripherique`, `libelle`, `left`, `top`, `affich_libelle`, `url`, `vue_id`) SELECT pe.`periph`, pe.`id`, pe.`nom`, pe.`left` + pl.`left`, pe.`top` + pl.`top`, pe.`texte`, pe.`logo`, v.`id` FROM `peripheriques` pe, `plan` pl, `vues` v WHERE pe.`icone`=1 AND pe.`id_plan`>=0 AND pe.`libelle` ='' AND pl.`id` = pe.`id_plan` AND v.`libelle`='plan';

--
-- On crée également un autre objet, le rapport, qui permet d'afficher des données et actions (boutons on/off, scénarios, caméras, graphiques du mode plan actuel)
--
CREATE TABLE IF NOT EXISTS `rapports` (
  `id` int(1) NOT NULL AUTO_INCREMENT,
  `libelle` varchar(50) NOT NULL,
  `left` int(1) NOT NULL,
  `top` int(1) NOT NULL,
  `width` int(1) NOT NULL,
  `height` int(1) NOT NULL,
  `icone` varchar(22) NOT NULL,
  PRIMARY KEY (`id`)
) ;

CREATE TABLE IF NOT EXISTS `rapports_onglets` (
  `id` int(1) NOT NULL AUTO_INCREMENT,
  `id_rapport` int(1) NOT NULL,
  `libelle` varchar(50) NOT NULL,
  `ordre` int(1) NOT NULL,
  PRIMARY KEY (`id`)
) ;

CREATE TABLE IF NOT EXISTS `rapports_elements` (
  `id` int(1) NOT NULL AUTO_INCREMENT,
  `id_onglet` int(1) NOT NULL,
  `libelle` varchar(50) NOT NULL,
  `type` varchar(50) NOT NULL,
  `periph` varchar(50) NOT NULL,
  PRIMARY KEY (`id`)
) ;

--
-- On récupère tout ce qui était affiché dans les popups des pièces du plan
--
-- Un rapport par pièce, le bouton permettant d'afficher le rapport fait la taille de la pièce, sans icone, donc le rapport s'affiche quand on clique sur la pièce
INSERT INTO `rapports` (`libelle`, `left`, `top`, `width`, `height`) SELECT `libelle`, `left`, `top`, 'width', 'height' FROM `plan` WHERE 1=1;
--
-- On crée tous les onglets possibles dans un premier temps, on supprimera ensuite ceux qui sont vide
--
INSERT INTO `rapports_onglets` (`id_rapport`, `libelle`, `ordre`) SELECT r.`id`, 'Actionneurs', '1' FROM `rapports` r WHERE 1;
INSERT INTO `rapports_onglets` (`id_rapport`, `libelle`, `ordre`) SELECT r.`id`, 'Scénarios', '2' FROM `rapports` r WHERE 1;
INSERT INTO `rapports_onglets` (`id_rapport`, `libelle`, `ordre`) SELECT r.`id`, 'Conso élec', '3' FROM `rapports` r WHERE 1;
INSERT INTO `rapports_onglets` (`id_rapport`, `libelle`, `ordre`) SELECT r.`id`, 'Températures', '4' FROM `rapports` r WHERE 1;
INSERT INTO `rapports_onglets` (`id_rapport`, `libelle`, `ordre`) SELECT r.`id`, 'Anémométrie', '5' FROM `rapports` r WHERE 1;
INSERT INTO `rapports_onglets` (`id_rapport`, `libelle`, `ordre`) SELECT r.`id`, 'Pluviométrie', '6' FROM `rapports` r WHERE 1;
INSERT INTO `rapports_onglets` (`id_rapport`, `libelle`, `ordre`) SELECT r.`id`, 'Luminosité', '7' FROM `rapports` r WHERE 1;
INSERT INTO `rapports_onglets` (`id_rapport`, `libelle`, `ordre`) SELECT r.`id`, 'Conso eau', '8' FROM `rapports` r WHERE 1;
INSERT INTO `rapports_onglets` (`id_rapport`, `libelle`, `ordre`) SELECT r.`id`, 'Caméras', '9' FROM `rapports` r WHERE 1;

-- On met dans les rapports le même contenu que le popup actuel du mode plan
-- Onglet actionneurs
INSERT INTO `rapports_elements` (`id_onglet`, `libelle`, `type`, `periph`) SELECT o.`id`, pe. `libelle`, 'periph', pe.`id` FROM `peripheriques` pe, `plan` pl, `rapports` r, `rapports_onglets` o WHERE pe.`libelle`!='' AND pe.`periph` = 'actioneur' AND pl.`id` = pe.`id_plan` AND r.`libelle` = pl.`libelle` AND o.`id_rapport`=r.`id` AND o.`libelle`='Actionneurs';
INSERT INTO `rapports_elements` (`id_onglet`, `libelle`, `type`, `periph`) SELECT o.`id`, pe. `nom`, 'periph', pe.`id` FROM `peripheriques` pe, `plan` pl, `rapports` r, `rapports_onglets` o WHERE pe.`libelle`='' AND pe.`periph` = 'actioneur' AND pl.`id` = pe.`id_plan` AND r.`libelle` = pl.`libelle` AND o.`id_rapport`=r.`id` AND o.`libelle`= 'Actionneurs' ;
-- Onglet scénarios
INSERT INTO `rapports_elements` (`id_onglet`, `libelle`, `type`, `periph`) SELECT o.`id`, s. `libelle`, 'scenario', s.`nom` FROM `scenarios` s, `plan` pl, `rapports` r, `rapports_onglets` o WHERE s.`libelle`!='' AND pl.`id` = s.`id_plan` AND r.`libelle` = pl.`libelle` AND o.`id_rapport`=r.`id` AND o.`libelle`= 'Scénarios' ;
INSERT INTO `rapports_elements` (`id_onglet`, `libelle`, `type`, `periph`) SELECT o.`id`, s. `nom`, 'scenario', s.`nom` FROM `scenarios` s, `plan` pl, `rapports` r, `rapports_onglets` o WHERE s.`libelle`='' AND pl.`id` = s.`id_plan` AND r.`libelle` = pl.`libelle` AND o.`id_rapport`=r.`id` AND o.`libelle`= 'Scénarios' ;
-- Onglet conso élec
INSERT INTO `rapports_elements` (`id_onglet`, `libelle`, `type`, `periph`) SELECT o.`id`, pe. `libelle`, 'periph', pe.`id` FROM `peripheriques` pe, `plan` pl, `rapports` r, `rapports_onglets` o WHERE pe.`libelle`!='' AND pe.`periph` = 'conso' AND pe.`graphique`=1 AND pl.`id` = pe.`id_plan` AND r.`libelle` = pl.`libelle` AND o.`id_rapport`=r.`id` AND o.`libelle`= 'Conso élec' ;
INSERT INTO `rapports_elements` (`id_onglet`, `libelle`, `type`, `periph`) SELECT o.`id`, pe. `nom`, 'periph', pe.`id` FROM `peripheriques` pe, `plan` pl, `rapports` r, `rapports_onglets` o WHERE pe.`libelle`='' AND pe.`periph` = 'conso' AND pe.`graphique`=1 AND pl.`id` = pe.`id_plan` AND r.`libelle` = pl.`libelle` AND o.`id_rapport`=r.`id` AND o.`libelle`= 'Conso élec' ;
-- Onglet température
INSERT INTO `rapports_elements` (`id_onglet`, `libelle`, `type`, `periph`) SELECT o.`id`, pe. `libelle`, 'periph', pe.`id` FROM `peripheriques` pe, `plan` pl, `rapports` r, `rapports_onglets` o WHERE pe.`libelle`!='' AND pe.`periph` = 'temperature' AND pe.`graphique`=1 AND pl.`id` = pe.`id_plan` AND r.`libelle` = pl.`libelle` AND o.`id_rapport`=r.`id` AND o.`libelle`= 'Températures' ;
INSERT INTO `rapports_elements` (`id_onglet`, `libelle`, `type`, `periph`) SELECT o.`id`, pe. `nom`, 'periph', pe.`id` FROM `peripheriques` pe, `plan` pl, `rapports` r, `rapports_onglets` o WHERE pe.`libelle`='' AND pe.`periph` = 'temperature' AND pe.`graphique`=1 AND pl.`id` = pe.`id_plan` AND r.`libelle` = pl.`libelle` AND o.`id_rapport`=r.`id` AND o.`libelle`= 'Températures' ;
-- Onglet vent
INSERT INTO `rapports_elements` (`id_onglet`, `libelle`, `type`, `periph`) SELECT o.`id`, pe. `libelle`, 'periph', pe.`id` FROM `peripheriques` pe, `plan` pl, `rapports` r, `rapports_onglets` o WHERE pe.`libelle`!='' AND pe.`periph` = 'vent' AND pe.`graphique`=1 AND pl.`id` = pe.`id_plan` AND r.`libelle` = pl.`libelle` AND o.`id_rapport`=r.`id` AND o.`libelle`='Anémométrie' ;
INSERT INTO `rapports_elements` (`id_onglet`, `libelle`, `type`, `periph`) SELECT o.`id`, pe. `nom`, 'periph', pe.`id` FROM `peripheriques` pe, `plan` pl, `rapports` r, `rapports_onglets` o WHERE pe.`libelle`='' AND pe.`periph` = 'vent' AND pe.`graphique`=1 AND pl.`id` = pe.`id_plan` AND r.`libelle` = pl.`libelle` AND o.`id_rapport`=r.`id` AND o.`libelle`= 'Anémométrie' ;
-- Onglet pluie
INSERT INTO `rapports_elements` (`id_onglet`, `libelle`, `type`, `periph`) SELECT o.`id`, pe. `libelle`, 'periph', pe.`id` FROM `peripheriques` pe, `plan` pl, `rapports` r, `rapports_onglets` o WHERE pe.`libelle`!='' AND pe.`periph` = 'pluie' AND pe.`graphique`=1 AND pl.`id` = pe.`id_plan` AND r.`libelle` = pl.`libelle` AND o.`id_rapport`=r.`id` AND o.`libelle`= 'Pluviométrie' ;
INSERT INTO `rapports_elements` (`id_onglet`, `libelle`, `type`, `periph`) SELECT o.`id`, pe. `nom`, 'periph', pe.`id` FROM `peripheriques` pe, `plan` pl, `rapports` r, `rapports_onglets` o WHERE pe.`libelle`='' AND pe.`periph` = 'pluie' AND pe.`graphique`=1 AND pl.`id` = pe.`id_plan` AND r.`libelle` = pl.`libelle` AND o.`id_rapport`=r.`id` AND o.`libelle`= 'Pluviométrie' ;
-- Onglet luminosité
INSERT INTO `rapports_elements` (`id_onglet`, `libelle`, `type`, `periph`) SELECT o.`id`, pe. `libelle`, 'periph', pe.`id` FROM `peripheriques` pe, `plan` pl, `rapports` r, `rapports_onglets` o WHERE pe.`libelle`!='' AND pe.`periph` = 'luminosite' AND pe.`graphique`=1 AND pl.`id` = pe.`id_plan` AND r.`libelle` = pl.`libelle` AND o.`id_rapport`=r.`id` AND o.`libelle`= 'Luminosité' ;
INSERT INTO `rapports_elements` (`id_onglet`, `libelle`, `type`, `periph`) SELECT o.`id`, pe. `nom`, 'periph', pe.`id` FROM `peripheriques` pe, `plan` pl, `rapports` r, `rapports_onglets` o WHERE pe.`libelle`='' AND pe.`periph` = 'luminosite' AND pe.`graphique`=1 AND pl.`id` = pe.`id_plan` AND r.`libelle` = pl.`libelle` AND o.`id_rapport`=r.`id` AND o.`libelle`= 'Luminosité' ;
-- Onglet conso eau
INSERT INTO `rapports_elements` (`id_onglet`, `libelle`, `type`, `periph`) SELECT o.`id`, pe. `libelle`, 'periph', pe.`id` FROM `peripheriques` pe, `plan` pl, `rapports` r, `rapports_onglets` o WHERE pe.`libelle`!='' AND pe.`periph` = 'eau' AND pe.`graphique`=1 AND pl.`id` = pe.`id_plan` AND r.`libelle` = pl.`libelle` AND o.`id_rapport`=r.`id` AND o.`libelle`= 'Conso eau' ;
INSERT INTO `rapports_elements` (`id_onglet`, `libelle`, `type`, `periph`) SELECT o.`id`, pe. `nom`, 'periph', pe.`id` FROM `peripheriques` pe, `plan` pl, `rapports` r, `rapports_onglets` o WHERE pe.`libelle`='' AND pe.`periph` = 'eau' AND pe.`graphique`=1 AND pl.`id` = pe.`id_plan` AND r.`libelle` = pl.`libelle` AND o.`id_rapport`=r.`id` AND o.`libelle`= 'Conso eau' ;
-- Onglet caméras
INSERT INTO `rapports_elements` (`id_onglet`, `libelle`, `type`, `periph`) SELECT o.`id`, c.`libelle`, 'camera', c.`id` FROM `video` c, `plan` pl, `rapports` r, `rapports_onglets` o WHERE pl.`id` = c.`id_plan` AND r.`libelle` = pl.`libelle` AND o.`id_rapport`=r.`id` AND o.`libelle`= 'Caméras' ;



-- supprimer paramètres 18 à 22


