<?php

class ModFadeImagesHelper
{
 public static function init($params)
 {
  $fadeimages = array();
  $folder = trim($params->get('folder'));
  $fadeimages['step'] = $params->get('step', 2);
  $fadeimages['interval'] = $params->get('interval', 35);
  $fadeimages['sleep'] = $params->get('sleep', 7000);

  $fadeimages['inet'] = JURI::root(false).$folder;
  $fadeimages['local'] = JPATH_BASE.'/'.$folder;

  $regex = '/((\.jpg)|(\.png))$/i';

  $dh = opendir($fadeimages['local']);
  if ( !$dh ) die('NOT_FOLDER');

  $fadeimages['files'] = array();
  while (false !== ($filename = readdir($dh))) {
   if ( is_file("{$fadeimages['local']}/{$filename}") && preg_match($regex, $filename) ) {
    $fadeimages['files'][] = $filename;
   }
  }

  srand((float) microtime() * 10000000);
  shuffle($fadeimages['files']);
  $fadeimages['list'] = '';
  foreach ($fadeimages['files'] as $id => $filename) $fadeimages['list'] .= ($id ? ', ' : '')."\"{$filename}\"";

  return $fadeimages;
 }
}