<?php
/**
 * @package
 * @subpackage Components
 * @license    GNU/GPL
 */

// no direct access
defined( '_JEXEC' ) or die( 'Restricted access' );

jimport('joomla.application.component.controller');

/**
 * Delivery Component Controller
 *
 * @package
 * @subpackage Components
 */
class DeliveryController extends JController
{
    function display()
    {
	global $mainframe;
	$document = &JFactory::getDocument();
	$document->addStyleSheet( JURI::root(true) . '/components/com_delivery/style.css' );

	$view_name = JRequest::getCmd('view');

	$view =& $this->getView($view_name, 'html'); 
	$view->display();
    }
}
?>