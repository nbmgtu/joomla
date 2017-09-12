<?php
defined('_JEXEC') or die('Restricted access');

class JournalController extends JControllerLegacy
{
 function display($cachable = false, $urlparams = false)
 {
  $document = JFactory::getDocument();
  $document->addStyleSheet("/components/".$this->input->get('option')."/css/style.css");
  $document->addScript("/components/".$this->input->get('option')."/js/script.js");

  return parent::display($cachable, $urlparams);
 }

}
