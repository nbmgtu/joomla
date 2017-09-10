<?php
defined('_JEXEC') or die('Restricted access');

class PhotoAlbumViewAlbums extends JViewLegacy
{
 function display($tpl = null)
 {
  $this->data = $this->get('Albums');

  if (count($errors = $this->get('Errors')))
  {
   JLog::add(implode('<br />', $errors), JLog::WARNING, 'jerror');
   return false;
  }

  parent::display($tpl);
 }
}
