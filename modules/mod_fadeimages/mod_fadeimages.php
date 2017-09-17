<?php
defined('_JEXEC') or die('Restricted access');

function getFiles(&$params)
{
 $fadeimages = array();
 $folder = trim($params->get('folder'));
 $local = JPATH_BASE."{$folder}";

// $fadeimages['inet'] = $folder;
// $fadeimages['step'] = $params->get('step', 2);
// $fadeimages['interval'] = $params->get('interval', 35);
// $fadeimages['sleep'] = $params->get('sleep', 7000);

 $regex = '/((\.jpg)|(\.png))$/i';
 if ( !($dh = opendir($local)) ) return false;

 $fadeimages = array();
 while (false !== ($filename = readdir($dh))) {
  if ( is_file("{$local}/{$filename}") && preg_match($regex, $filename) ) $fadeimages[] = "{$folder}{$filename}";
 }

 return $fadeimages;
}

$document = JFactory::getDocument();
$document->addStyleSheet("/modules/mod_fadeimages/assets/owlcarousel/owl.carousel.min.css");
$document->addStyleSheet("/modules/mod_fadeimages/assets/owlcarousel/owl.theme.default.min.css");
$document->addScript("/modules/mod_fadeimages/assets/owlcarousel/owl.carousel.min.js");
$document->addScript("/modules/mod_fadeimages/js/fadeimages.js");
$document->addStyleSheet("/modules/mod_fadeimages/css/fadeimages.css");
//$document->addScriptOptions('mod_fadeimages', getOptions($params));
$files = getFiles($params);

require JModuleHelper::getLayoutPath('mod_fadeimages', $params->get('layout', 'default'));
