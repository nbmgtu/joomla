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
 * PhotoAlbum Component Controller
 *
 * @package
 * @subpackage Components
 */
class PhotoAlbumController extends JController
{
    function display()
    {
	global $mainframe;
	$document = &JFactory::getDocument();
	$document->addStyleSheet( JURI::root(true) . '/components/com_photoalbum/style.css' );

	$params = &$mainframe->getParams();
	$folder = $params->def( 'folder', 'images/stories/' );

	$view_name = JRequest::getCmd('view');
	$subfolder = JRequest::getCmd('folder');
	$subfolder = preg_match('/^[-a-zA-Z0-9_]{1,25}$/', $subfolder) ? $subfolder : false;
	$Itemid = (int)JRequest::getCmd('Itemid');

	$view =& $this->getView($view_name, 'html');
	$view->folder = $folder . ( $subfolder ? $subfolder . '/' : '' );
	$view->Itemid = $Itemid;
	$view->hasParent = (bool)$subfolder;
	$view->display();
    }
}
?>