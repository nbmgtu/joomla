<?php
defined('_JEXEC') or die('Restricted access');

class DebtsModelDebts extends JModelItem
{
 function getUrl()
 {
  $application = JFactory::getApplication();
  $params = $application->getParams();

  $url = $params->get('url');
  $mode = urlencode(trim($application->input->get('mode', '', 'STRING')));
  $kurs = urlencode(trim($application->input->get('kurs', '', 'STRING')));
  $facultet = urlencode(trim($application->input->get('facultet', '', 'STRING')));

  return "{$url}?mode={$mode}&kurs={$kurs}&facultet={$facultet}";
 }
}
