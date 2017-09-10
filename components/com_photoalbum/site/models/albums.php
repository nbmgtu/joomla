<?php
defined('_JEXEC') or die('Restricted access');

class PhotoAlbumModelAlbums extends JModelItem
{
 private $folder;
 private $local;
 private $cache;
 private $cache_inet;

 function init()
 {
  if ( !empty($this->folder) ) return;

  $application = JFactory::getApplication();
  $params = $application->getParams();

  $this->folder = $params->get('folder');
  $this->local = JPATH_BASE."/{$this->folder}";
  $this->cache_inet = "/cache/{$this->option}/{$this->folder}";
  $this->cache = JPATH_BASE.$this->cache_inet;
 }

 function getAlbums()
 {
  $this->init();

  if ( !($hAlbum = opendir($this->local)) )
  {
   $this->setError(JText::_('PHOTOALBUM_FOLDERNOTOPENED').": {$this->local}");
   return false;
  }

  $albums = array();

  while (($filename = readdir($hAlbum)) !== false)
  {
   $path = "{$this->local}{$filename}";
   $path_cache = "{$this->cache}{$filename}";
   $path_cache_inet = "{$this->cache_inet}{$filename}";
   if ( !is_dir($path) || preg_match('/^\./', $filename) ) continue;

   $albums[$filename]['href'] = JRoute::_(array('album' => $filename));
   $albums[$filename]['time'] = filemtime($path);
   $albums[$filename]['readme'] = @file_get_contents("{$path}/readme");

   if ( ($hImage = opendir($path)) )
   {
    while (($image = readdir($hImage)) !== false)
    {
     if ( is_file("{$path}/{$image}" ) && preg_match('/^[\S]+(\.jpg|\.png)$/i', $image) )
     {
      $albums[$filename]['image'] = "{$path}/{$image}";

      $thmb = "{$path_cache}/{$image}";
      if ( is_file($thmb) ) $albums[$filename]['image_thmb'] = "{$path_cache_inet}/{$image}";

      break;
     }
    }
    closedir($hImage);
   }


  }
  closedir($hAlbum);

  if ( empty($albums) )
  {
   $this->setError(JText::_('PHOTOALBUM_SUBFOLDERNOTFOUND').": {$this->local}");
   return false;
  }

  uasort($albums, array($this, 'compare'));

  $readme = @file_get_contents("{$this->local}/readme");

  return array('readme' => $readme, 'albums' => $albums);
 }

 function compare($a, $b) {
  if ($a['time'] == $b['time']) return 0;
  return ($a['time'] > $b['time']) ? -1 : 1;
 }

}
