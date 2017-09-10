<?php
defined( '_JEXEC' ) or die( 'Restricted access' );

jimport( 'joomla.application.component.view');

require_once(JPATH_BASE.DS.'components/com_journal/views/view.utils.php');

class JournalViewEditorialboard extends UtilsView
{
 function display($tpl = null)
 {
  parent::display($tpl);
 }
}
