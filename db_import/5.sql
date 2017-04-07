ALTER TABLE `photo` ADD `position` INT NOT NULL DEFAULT '1' AFTER `status`;
ALTER TABLE `album` ADD `chpu` VARCHAR(255) NOT NULL AFTER `date`;
ALTER TABLE `album` ADD UNIQUE `chpu` (`chpu`);
