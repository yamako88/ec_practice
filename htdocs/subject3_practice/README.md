CREATE TABLE `codecamp26607`.`EC_users` ( `id` INT(20) NOT NULL AUTO_INCREMENT , `name` VARCHAR(30) NOT NULL , `password` VARCHAR(30) NOT NULL , `create_datetime` DATETIME NOT NULL , `update_datetime` DATETIME NOT NULL , PRIMARY KEY (`id`)) ENGINE = InnoDB;

CREATE TABLE `codecamp26607`.`EC_items` ( `id` INT(20) NOT NULL AUTO_INCREMENT , `name` VARCHAR(30) NOT NULL , `price` INT(10) NOT NULL , `img` VARCHAR(255) NOT NULL , `status` INT(10) NOT NULL , `create_datetime` DATETIME NOT NULL , `update_datetime` DATETIME NOT NULL , PRIMARY KEY (`id`)) ENGINE = InnoDB;
