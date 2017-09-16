<?php
defined('_JEXEC') or die('Restricted access');

require_once('components/com_journal/models/default.php');

class JournalModelIssue extends JournalModel
{
 function setHits($hash)
 {
  $db = JFactory::getDbo();
  $db->setQuery("SELECT `hits` FROM `#__{$this->option}` WHERE `hash` = '{$hash}'");
  $hits = intval($db->loadResult()) + 1;
  $db->setQuery("UPDATE `#__{$this->option}` SET `hits` = `hits` + 1 WHERE `hash` = '{$hash}'");
  $db->execute();
  if ( $db->getAffectedRows() <= 0 ) {
   $db->setQuery("REPLACE INTO `#__{$this->option}` SET `hits` = {$hits}, `hash` = '{$hash}'");
   $db->execute();
  }

  return $hits;
 }

 function getData()
 {
  $this->init();

  $application = JFactory::getApplication();
  $params = $application->getParams();

  $issue = $application->input->get('issue', '', 'CMD');
  if ( !preg_match($this->pattern, $issue, $matches) || !($local = "{$this->local}{$issue}/") || !is_dir($local) )
  {
   $this->setError(JText::_('COM_JOURNAL_ISSUE_NOTFOUND').": {$issue}");
   return;
  }

  $folder = "{$this->folder}{$issue}/";
  $hits = $this->setHits(md5($folder));

  foreach ($this->content as $language => &$body)
  {
   $data = @file("{$local}content_{$language}.txt", FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
   if ( empty($data) ) continue;

   $fid = 0;
   $open = false;
   $haspage = false;

   foreach ($data as $line)
   {
    if ( $line[0] == "\t") $fid++;

    if ( $line[0] != "\t" )
    {
     if ( $open ) $body .= "</ul></div>";
     $body .= "<p class=\"jheader\">{$line}</p><div><ul class=\"%HASPAGE%\" style=\"text-align: justify;\">";
     $open = true;
    } else
    {
     $tmp = explode('|', $line, 3);
     $author = trim($tmp[0]);
     $name = trim($tmp[1]);
     $page = trim(@$tmp[2]);
     if ( !empty($page) ) $haspage = true;
     $fname = sprintf('%03d', $fid);
     $body .= "<li><span class=\"text\"><a href=\"{$folder}{$fname}.pdf\" target=\"_blank\"><b>{$author}</b> {$name}</a></span><span class=\"page\">{$page}</span></li>";
    }

   }
   $body .= "</ul></div>";
   $body = str_replace("%HASPAGE%", ($haspage ? "oglavl" : ""), $body);
  }

  return array('title' => "{$this->title}, ".JText::_('COM_JOURNAL_ISSUES_ISSUE')." {$matches[2]} ({$matches[1]})", 'content' => $this->content);
 }
}
