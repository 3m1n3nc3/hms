CREATE TABLE `hmsystem`.`card_state` ( 
    `id` INT NOT NULL AUTO_INCREMENT , 
    `page` VARCHAR(128) NULL DEFAULT NULL , 
    `card_id` VARCHAR(128) NULL DEFAULT NULL , 
    `state` VARCHAR(128) NULL DEFAULT NULL , 
    PRIMARY KEY (`id`)
) ENGINE = InnoDB;

ALTER TABLE `card_state` 
    ADD `uid` INT(11) NULL DEFAULT NULL AFTER `id`, 
    ADD INDEX `uid` (`uid`);
