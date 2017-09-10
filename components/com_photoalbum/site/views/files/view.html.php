<?php
defined('_JEXEC') or die('Restricted access');

class PhotoAlbumViewFiles extends JViewLegacy
{
 function display($tpl = null)
 {
  $this->data = $this->get('Files');

  if (count($errors = $this->get('Errors')))
  {
   JLog::add(implode('<br />', $errors), JLog::WARNING, 'jerror');
   return false;
  }

  parent::display($tpl);
 }
}
