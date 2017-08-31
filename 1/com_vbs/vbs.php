<?php
defined( '_JEXEC' ) or die( 'Restricted access' );

require_once( JPATH_COMPONENT . '/controller.php' );

$controller = new VbsController();

$controller->execute(JRequest::getVar('task'));

$controller->redirect();
?>