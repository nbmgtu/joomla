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
 * Debts Component Controller
 *
 * @package
 * @subpackage Components
 */
class NewsliteratureController extends JController
{
    function display()
    {
	$document = &JFactory::getDocument();

	$view_name = JRequest::getCmd('view');

	$view =& $this->getView($view_name, 'html'); 
	$view->display();
    }
}
