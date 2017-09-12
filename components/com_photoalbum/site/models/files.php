<?php
defined('_JEXEC') or die('Restricted access');

class PhotoAlbumModelFiles extends JModelItem
{
 private $folder;
 private $local;
 private $local_inet;
 private $cache;
 private $cache_inet;
 private $album;
 private $hits;

 function init()
 {
  if ( !empty($this->folder) ) return;

  $application = JFactory::getApplication();
  $params = $application->getParams();

  $this->folder = $params->get('folder');
  $this->album = $application->input->get('album', '', 'CMD');
  $this->local_inet = "{$this->folder}/{$this->album}";
  $this->local = JPATH_BASE.$this->local_inet;
  $this->cache_inet = "/cache/{$this->option}{$this->folder}/$this->album";
  $this->cache = JPATH_BASE.$this->cache_inet;
 }

 function setHits()
 {
  @mkdir($this->cache, 0755, true);
  $fname = "{$this->cache}/.hits";
  $this->hits = intval(@file_get_contents($fname)) + 1;
  file_put_contents($fname, $this->hits);
 }

 function getFiles()
 {
  $this->init();
  $this->setHits();

  if ( !($hAlbum = opendir($this->local)) )
  {
   $this->setError(JText::_('COM_PHOTOALBUM_FOLDERNOTOPENED').": {$this->local}");
   return false;
  }

  $regex_img = '/\.jpg|\.png$/i';
  $regex_video = '/\.mov|\.mp4|\.m4v|\.flv|\.ogv|\.avi|\.mpg|\.mkv$/i';
  $files = array();

  while (($filename = readdir($hAlbum)) !== false)
  {
   $path = "{$this->local}/{$filename}";
   $path_inet = "{$this->local_inet}/{$filename}";
   $path_cache = "{$this->cache}/{$filename}";
   $path_cache_inet = "{$this->cache_inet}/{$filename}";

   if ( !is_file($path) ) continue;

   if ( preg_match($regex_img, $filename) )
   {
    // preview
    if ( !is_file($path_cache) ) $this->createThmb($path, $path_cache);
    $files[] = array('type' => 'image', 'src' => $path_inet, 'alt' => @file_get_contents("{$path}.alt"), 'title' => @file_get_contents("{$path}.title"), 'thmb' => $path_cache_inet);
   }
   else if ( preg_match($regex_video, $filename) )
   {
    // TODO: create preview from video
    $thmb = "{$path}.preview";
    if ( !is_file($thmb) ) $thmb = false; else $thmb = "{$path_inet}.preview";
    $files[$id] = array('type' => 'video', 'src' => $path_inet, 'alt' => @file_get_contents("{$path}.alt"), 'title' => @file_get_contents("{$path}.title"), 'thmb' => $thmb);
   }

  }
  closedir($hAlbum);

  if ( empty($files) )
  {
   $this->setError(JText::_('PHOTOALBUM_ISEMPTY').": {$this->local}");
   return false;
  }

  $readme = @file_get_contents("{$this->local}/readme");

  return array('readme' => $readme, 'hits' => $this->hits, 'back' => JRoute::_(array('view' => false, 'album' => false)), 'files' => $files);
 }

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
   case 'jpg': imagejpeg($tmp, $dest, 75); break;
   case 'png': imagepng($tmp, $dest, 7); break;
  }

  imagedestroy($src);
  imagedestroy($tmp);
 }

}
