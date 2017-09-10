<?php
defined('_JEXEC') or die('Restricted access');

jimport( 'joomla.application.component.view');

class VbsViewMain extends JView
{
 function display($tpl = null)
 {
  $this->loadArrays();
  parent::display($tpl);
 }

 function loadArrays()
 {
  $lastmessage = '';
  $mode_append_topic = 'Добавить новую тематику';
  $mode_edit_topic = 'Редактировать тематику';

  $this->assignRef('mode_append_topic', $mode_append_topic);
  $this->assignRef('mode_edit_topic', $mode_edit_topic);

  $db = JFactory::getDBO();

  if (  in_array($this->mode, array($mode_append_topic, $mode_edit_topic)) ) {

   $name = mysql_real_escape_string($this->newtopic['name']);
   $description = mysql_real_escape_string($this->newtopic['description']);

   $query =
     ($this->mode == $mode_append_topic ? 'INSERT INTO ' : 'UPDATE ').'#__vbs_topics '.
     "SET position = {$this->newtopic['position']}, name = '{$name}', description = '{$description}' ".
     ($this->mode == $mode_edit_topic ? "WHERE id = {$this->topic}" : '');
   $db->setQuery($query);
   if ( !$db->query() ) JError::raiseError(500, $db->stderr(true));

   $this->topic = 0;
   $lastmessage = '<b><font color=green>'.($this->mode == $mode_append_topic ? 'Новая тематика добавлена' : 'Тематика изменена').'</font></b>';

  }

  $this->assignRef('lastmessage', $lastmessage);

  if ( $this->topic ) {

   $query =
    'SELECT position, name, description '.
    'FROM #__vbs_topics '.
    "WHERE id = {$this->topic}";
   $db->setQuery($query);
   if ( !$db->query() ) JError::raiseError(500, $db->stderr(true));
   $topic = $db->loadAssoc();
   if ( !$topic ) JError::raiseError(500, JText::_('VBS_BAD_TOPIC_ID'));
   $this->assignRef('db_topic', $topic);
  }

  $query =
   'SELECT id, name, description '.
   'FROM #__vbs_topics '.
   'ORDER BY position';
  $db->setQuery($query);
  if ( !$db->query() ) JError::raiseError(500, $db->stderr(true));
  $this->assignRef('db_topics', $db->loadAssocList());
 }

}
?>