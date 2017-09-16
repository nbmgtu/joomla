CREATE TABLE IF NOT EXISTS `#__com_journal` (
 `hash` CHAR(32) NOT NULL,
 `hits` integer unsigned NOT NULL,
 PRIMARY KEY (`hash`)
)
ENGINE = MyISAM;
