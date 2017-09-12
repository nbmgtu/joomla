<?php
defined('_JEXEC') or die('Restricted access');

require_once('components/com_journal/models/default.php');

class JournalModelMain extends JournalModel
{
 function getData()
 {
  $this->init();

  $this->link = array(
   'editorialboard' => JRoute::_(array('view' => 'editorialboard')),
   'issues' => JRoute::_(array('view' => 'issues')),
   'informationforauthors' => JRoute::_(array('view' => 'informationforauthors')),
   'logo' => "{$this->folder}/logo.jpg"
  );

  foreach ($this->content as $language => &$body) $body = @file_get_contents("{$this->local}/description_{$language}.htm");

  return array('folder' => $this->folder, 'local' => $this->local, 'title' => $this->title, 'link' => $this->link, 'content' => $this->content);
 }
}
