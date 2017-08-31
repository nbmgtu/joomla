<?php
defined( '_JEXEC' ) or die( 'Restricted access' );

jimport( 'joomla.application.component.view');

class DeliveryViewMain extends JView
{
 function display($tpl = null)
 {
  $this->loadArrays();
  parent::display($tpl);
 }

 function loadArrays()
 {
  $db = JFactory::getDBO();

  $query =
   'SELECT id, param, title '.
   'FROM #__delivery_intervals '.
   'ORDER BY id';
  $db->setQuery($query);
  if ( !$db->query() ) JError::raiseError(500, $db->stderr(true));
  $this->assignRef('db_intervals', $db->loadAssocList());

  $user =& JFactory::getUser();
  $userID = intval($user->get('id'));

  if ( !$userID ) JError::raiseError(500, JText::_('DELIVERY_USERNOTDEFINED'));

  // сохраняем
  $delivery_template = JRequest::getVar('delivery_template');
  if ( is_array($delivery_template) ) {
   reset($delivery_template);
   foreach ($delivery_template as $templateID => $intervalID) {
    if ( $intervalID ) { // установлен период $intervalID для $templateID для $userID
     // смотрим был ли такой шаблон
     $query =
      "SELECT COUNT(*) ".
      "FROM #__delivery_settings ".
      "WHERE user_id = {$userID} AND template_id = {$templateID} AND interval_id = {$intervalID}";
     $db->setQuery($query);
     if ( !$db->query() ) JError::raiseError(500, $db->stderr(true));
     if ( !$db->loadResult() ) { // если нет, то пересоздаем
      $query =
       "REPLACE INTO #__delivery_settings ".
       "SET user_id = {$userID}, template_id = {$templateID}, interval_id = {$intervalID}";
      $db->setQuery($query);
      if ( !$db->query() ) JError::raiseError(500, $db->stderr(true));
     }
    } else { // удалить у $userID настройку для $templateID
     $query =
      "DELETE FROM #__delivery_settings ".
      "WHERE user_id = {$userID} AND template_id = {$templateID}";
     $db->setQuery($query);
     if ( !$db->query() ) JError::raiseError(500, $db->stderr(true));
    }
   }
  }

  // читаем
  $query =
   'SELECT dt.id, dt.template_group_id, dt.title, ds.interval_id, dtg.title AS title_group '.
   "FROM #__delivery_templates dt LEFT JOIN #__delivery_settings ds ON (ds.user_id = {$userID} AND ds.template_id = dt.id) LEFT JOIN #__delivery_templates_group dtg ON (dtg.id = dt.template_group_id) ".
   'ORDER BY dt.template_group_id, dt.id';
  $db->setQuery($query);
  if ( !$db->query() ) JError::raiseError(500, $db->stderr(true));
  $this->assignRef('db_templates', $db->loadAssocList());

 }
}

?>
