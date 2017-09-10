<?php
defined('_JEXEC') or die('Restricted access');

class DebtsViewDebts extends JViewLegacy
{
 function display($tpl = null)
 {
  $this->url = $this->get('Url');

  if (count($errors = $this->get('Errors')))
  {
   JLog::add(implode('<br />', $errors), JLog::WARNING, 'jerror');
   return false;
  }

  parent::display($tpl);
 }
}
