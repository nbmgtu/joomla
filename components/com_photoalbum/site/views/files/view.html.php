<?php
defined('_JEXEC') or die('Restricted access');

class PhotoAlbumViewFiles extends JViewLegacy
{
 function display($tpl = null)
 {
  $this->data = $this->get('Files');
  $this->audios = $this->get('Audios');

  if ( !empty($this->audios) )
  {
   $document = JFactory::getDocument();
   $document->addScript("/components/com_photoalbum/js/script.js");
   $document->addScriptOptions('com_photoalbum', $this->audios);
  }

  if (count($errors = $this->get('Errors')))
  {
   JLog::add(implode('<br />', $errors), JLog::WARNING, 'jerror');
   return false;
  }

  parent::display($tpl);
 }
}
