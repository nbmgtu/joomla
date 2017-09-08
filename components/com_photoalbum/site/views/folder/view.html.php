<?php
defined('_JEXEC') or die('Restricted access');

class PhotoAlbumViewFolder extends JViewLegacy
{
 function display($tpl = null)
 {
  $this->data = $this->get('Folders');

  if (count($errors = $this->get('Errors')))
  {
   JLog::add(implode('<br />', $errors), JLog::WARNING, 'jerror');
   return false;
  }

  parent::display($tpl);
 }
}
