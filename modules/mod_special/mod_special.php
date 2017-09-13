<?php
defined('_JEXEC') or die('Restricted access');

$cfg = array('cmd' => 'current', 'title' => 'SPECIAL VERSION');

$session = JFactory::getSession();
$application = JFactory::getApplication();
$special = $application->input->get('special', NULL, 'WORD');

if ( $special === NULL ) $special = $session->get('special', '', 'mod_special');
else {
 $special = empty($special) ? '' : $cfg['cmd'];
 $session->set('special', $special, 'mod_special');
}

if ( empty($special) ) {
 $document = JFactory::getDocument();
 $document->addStyleSheet("/modules/mod_special/css/special.css");
 $special = $cfg['cmd'];
} else $special = '';

require JModuleHelper::getLayoutPath('mod_special', $params->get('layout', 'default'));
