<?php
defined('_JEXEC') or die('Restricted access');

$command = 'current';

$session = JFactory::getSession();
$application = JFactory::getApplication();
$special = $application->input->get('special', NULL, 'WORD');

if ( $special === NULL ) $special = $session->get('special', NULL, 'mod_special');
else {
 $special = empty($special) ? '' : $command;
 $session->set('special', $special, 'mod_special');
}

if ( !empty($special) ) {
 $document = JFactory::getDocument();
 $document->addStyleSheet("/modules/mod_special/css/special.css");
 $special = '';
 $class = $command;
} else {
 $special = $command;
 $class = '';
}

require JModuleHelper::getLayoutPath('mod_special', $params->get('layout', 'default'));
