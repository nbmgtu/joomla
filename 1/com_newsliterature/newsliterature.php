<?php
/**
 * @package
 * @subpackage Components
 * components/com_newsliterature/newsliterature.php
 * @license    GNU/GPL
*/

// no direct access
defined( '_JEXEC' ) or die( 'Restricted access' );

// Require the base controller
require_once( JPATH_COMPONENT.DS.'controller.php' );

// Create the controller
$controller = new NewsliteratureController();

// Perform the Request task
$controller->execute(JRequest::getVar('task'));

// Redirect if set by the controller
$controller->redirect();
