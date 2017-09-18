<?php
defined('_JEXEC') or die('Restricted access');

class NewsliteratureModelNewsliterature extends JModelItem
{
 function getUrl()
 {
  $application = JFactory::getApplication();
  $params = $application->getParams();

  $url = $params->get('url');
  $udk = urlencode(trim($application->input->get('udk', '', 'STRING')));
  $type = urlencode(trim($application->input->get('type', '', 'STRING')));
  $period = urlencode(trim($application->input->get('period', '', 'STRING')));
  $page = urlencode(trim($application->input->get('page', '', 'STRING')));

  return "{$url}?udk={$udk}&type={$type}&period={$period}&page={$page}";
 }
}
