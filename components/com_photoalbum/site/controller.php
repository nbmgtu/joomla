<?php
defined('_JEXEC') or die('Restricted access');

class PhotoAlbumController extends JControllerLegacy
{
 function display($cachable = false, $urlparams = false)
 {
  $document = JFactory::getDocument();
  $document->addStyleSheet(JUri::base()."/components/com_photoalbum/css/style.css");

  $view = $this->input->get('view', 'folder', 'WORD');
  $this->input->set('view', $view);

  parent::display($cachable, $urlparams);

  return $this;
 }

}
