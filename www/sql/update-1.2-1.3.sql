
--
-- Amélioration du module vidéo
--

ALTER TABLE `video` ADD `width` INT NOT NULL DEFAULT '640',
ADD `fps` INT NOT NULL,
ADD `delai` INT NOT NULL,
ADD `libelle` VARCHAR( 60 ) NOT NULL AFTER `id`,
ADD `ordre` INT( 3 ) NOT NULL AFTER `id` ;

--
-- Ajout du module conso_eau
--

INSERT INTO `modules` (`id` , `libelle` , `actif` , `ordre` ) VALUES ('20', 'conso_eau', '0', '0');

INSERT INTO `paramettres` (`id`, `libelle`, `value`, `type`) VALUES (43, 'cout eau', '3.52', 'number" step="0.01');