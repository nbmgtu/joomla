<?php
defined('_JEXEC') or die('Restricted access');

class JournalModel extends JModelItem
{
 function init()
 {
  $application = JFactory::getApplication();
  $params = $application->getParams();

  $this->folder = $params->get('folder');
  $this->local = JPATH_BASE."/{$this->folder}";
  $this->title = htmlspecialchars(@file_get_contents("{$this->local}/title.txt"));
  $this->pattern = "/^([0-9]{4})-([0-9]{2})$/";
  $this->content = array('ru' => '', 'en' => '');
 }
}
