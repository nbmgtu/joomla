<?php
defined('_JEXEC') or die('Restricted access');

class PhotoAlbumController extends JControllerLegacy
{
 function display($cachable = false, $urlparams = false)
 {
  $document = JFactory::getDocument();
  $document->addStyleSheet(JUri::base()."/components/".$this->input->get('option')."/css/style.css");

  $view = $this->input->get('view', 'albums', 'WORD');
  $this->input->set('view', $view);

  return parent::display($cachable, $urlparams);
 }

}
