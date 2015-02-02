
--
-- Amélioration du module vidéo
--

ALTER TABLE `video` ADD `width` INT NOT NULL DEFAULT '640',
ADD `fps` INT NOT NULL,
ADD `delai` INT NOT NULL,
ADD `libelle` VARCHAR( 60 ) NOT NULL AFTER `id`,
ADD `ordre` INT( 3 ) NOT NULL AFTER `id` ;

