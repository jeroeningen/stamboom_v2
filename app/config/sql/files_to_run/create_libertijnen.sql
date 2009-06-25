 CREATE TABLE `stamboom`.`people` (
`id` INT( 11 ) NOT NULL AUTO_INCREMENT PRIMARY KEY ,
`name` VARCHAR( 255 ) NOT NULL ,
`description` TEXT NOT NULL ,
`born` DATE NOT NULL ,
`died` DATE NOT NULL ,
`parent_id` INT( 11 ) NOT NULL ,
`lft` INT( 11 ) NOT NULL ,
`rght` INT( 11 ) NOT NULL ,
`created` DATETIME NOT NULL ,
`modified` DATETIME NOT NULL
) ENGINE = MYISAM;
