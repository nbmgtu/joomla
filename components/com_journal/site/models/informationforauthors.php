<?php
defined('_JEXEC') or die('Restricted access');

require_once('components/com_journal/models/default.php');

class JournalModelInformationforauthors extends JournalModel
{
 function getData()
 {
  $this->init();

  foreach ($this->content as $language => &$body) $body = @file_get_contents("{$this->local}/informationforauthors_{$language}.htm");

  return array('title' => $this->title, 'content' => $this->content);
 }
}
