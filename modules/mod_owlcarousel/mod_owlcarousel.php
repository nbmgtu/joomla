<?php
defined('_JEXEC') or die('Restricted access');

function createThmb($source, $dest, $max_width = 150, $max_height = 150)
{
 $src = imagecreatefromstring(file_get_contents($source));
 list($width, $height) = getimagesize($source);

 $x_ratio = $max_width / $width;
 $y_ratio = $max_height / $height;

 if ( ($width <= $max_width) && ($height <= $max_height) )
 {
  $tn_width = $width;
  $tn_height = $height;
 }
 elseif ( ($x_ratio * $height) < $max_height )
 {
  $tn_height = ceil($x_ratio * $height);
  $tn_width = $max_width;
 }
 else
 {
  $tn_width = ceil($y_ratio * $width);
  $tn_height = $max_height;
 }

 $tmp = imagecreatetruecolor($tn_width, $tn_height);
 imagecopyresampled($tmp, $src, 0, 0, 0, 0, $tn_width, $tn_height, $width, $height);

 switch ( strtolower(substr($dest, -3, 3)) )
 {
  case 'jpg': @imagejpeg($tmp, $dest, 75); break;
  case 'png': @imagepng($tmp, $dest, 7); break;
 }

 imagedestroy($src);
 imagedestroy($tmp);
}

function getImages(&$params)
{
 $folder = trim($params->get('folder'));
 $local = JPATH_BASE."{$folder}";

 $cache_inet = "/cache/mod_owlcarousel{$folder}";
 $cache = JPATH_BASE."{$cache_inet}";

 @mkdir($cache, 0700, TRUE);

 $regex = '/((\.jpg)|(\.png))$/i';
 if ( !($dh = opendir($local)) ) return false;

 $images = array();
 while (false !== ($filename = readdir($dh))) {
  if ( is_file("{$local}{$filename}") && preg_match($regex, $filename) )
  {
   if ( !is_file("{$cache}{$filename}") ) createThmb("{$local}{$filename}", "{$cache}{$filename}", 500, 205);
   $images[] = array('image' => "{$folder}{$filename}", 'thmb' => "{$cache_inet}{$filename}");
  }
 }

 return $images;
}

$document = JFactory::getDocument();
$document->addStyleSheet("/modules/mod_owlcarousel/css/owl.carousel.min.css");
$document->addStyleSheet("/modules/mod_owlcarousel/css/main.css");
$document->addScript("/modules/mod_owlcarousel/js/owl.carousel.min.js");
$document->addScript("/modules/mod_owlcarousel/js/main.js");
$images = getImages($params);

require JModuleHelper::getLayoutPath('mod_owlcarousel', $params->get('layout', 'default'));
