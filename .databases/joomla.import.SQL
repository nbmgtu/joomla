\W
DELIMITER $$

DROP PROCEDURE IF EXISTS joomla.import $$
CREATE DEFINER=`root`@`localhost` PROCEDURE joomla.import ()
BEGIN
 CALL joomla.import_content();
 CALL joomla.import_banner();
 CALL joomla.import_menu();
 CALL joomla.import_modules();
END $$

DELIMITER ;
