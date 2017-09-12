<?php
defined('_JEXEC') or die('Restricted access');

require_once('components/com_journal/models/default.php');

class JournalModelIssues extends JournalModel
{
 function getData()
 {
  $this->init();

  $issues = array();

  $i = 0;
  $items = scandir($this->local, SCANDIR_SORT_DESCENDING);
  foreach ($items as $name) {
   if ( !preg_match($this->pattern, $name, $matches) || !is_dir("{$this->local}/{$name}") ) continue;

   $issues[++$i] = array(
    'link' => JRoute::_(array('view' => 'issue', 'issue' => $name)),
    'title' => "{$this->title}, ".JText::_('COM_JOURNAL_ISSUES_ISSUE')." {$matches[2]} ({$matches[1]})",
    'hits' => @file_get_contents("{$this->local}/{$name}/hits")
   );
  }

  return array('title' => $this->title, 'issues' => $issues);
 }
}
