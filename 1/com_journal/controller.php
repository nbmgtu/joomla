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
 * Journal Component Controller
 *
 * @package
 * @subpackage Components
 */
class JournalController extends JController
{
 function ShowLangPage(&$content)
 {
  if ( ($content['ru'] != '') && ($content['en'] != '') ) {
?>
   <div id="page_ru" style="display: block" align="justify">
   <a href="javascript:getEN();">ENGLISH</a>
   <br><?= $content['ru']; ?></div>

   <div id="page_en" style="display: none">
   <a href="javascript:getRU();">Русский</a>
   <br><?= $content['en']; ?></div>
<?php
  } else {
   if ( $content['ru'] != '' ) echo $content['ru'];
   else if ( $content['en'] != '' ) echo $content['en'];
  }
 }

    function display()
    {
	global $mainframe;
	$document = &JFactory::getDocument();
	$document->addStyleSheet( JURI::root(true) . '/components/com_journal/style.css' );

	$params = &$mainframe->getParams();
	$cfg_folder = $params->def( 'folder', 'images/stories/journal-nt/' );
	$itemid = intval(JRequest::getCmd('Itemid'));
	$folder = JRequest::getCmd('folder');

	$view_name = JRequest::getCmd('view');

	$view =& $this->getView($view_name, 'html');
	$view->itemid = $itemid;
	$view->folder_local = JPATH_BASE.DS.$cfg_folder;
	$view->folder_inet = JURI::root(false).$cfg_folder;
        $view->title = htmlspecialchars(file_get_contents("{$view->folder_local}/title.txt"));

        $pattern = "/^([0-9]{4})-([0-9]{2})$/";
        if ( !preg_match($pattern, $folder, $matches) ) $view->issue_folder = false;
        else {
         $view->issue_folder = $folder;
         $view->issue_year = intval($matches[1]);
         $view->issue_number = intval($matches[2]);
        }

	$view->display();
    }
}
?>