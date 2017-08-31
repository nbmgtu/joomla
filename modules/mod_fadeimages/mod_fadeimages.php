<?php

defined('_JEXEC') or die;
require_once dirname(__FILE__) . '/helper.php';

$document = JFactory::getDocument();
$document->addScript(JURI::root(true)."/modules/mod_fadeimages/js/fadeimages.js");
$document->addStyleSheet(JURI::root(true)."/modules/mod_fadeimages/css/fadeimages.css");

$fadeimages = modFadeImagesHelper::init($params);
require JModuleHelper::getLayoutPath('mod_fadeimages', $params->get('layout', 'default'));
