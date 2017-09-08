<?php
defined('_JEXEC') or die('Restricted access');

class PhotoAlbumModelFolder extends JModelItem
{
 function getFolders()
 {
  $application = JFactory::getApplication();
  $params = $application->getParams();

  $folder = $params->get('folder');
  $path_local = JPATH_BASE."{$folder}";
  $path_thmb = JPATH_BASE."cache/nbmgtu/com_photoalbum{$folder}";

//  $this->Itemid = $application->input->getInt('Itemid', 0);

  if ( !is_dir($path_local) )
  {
   $this->setError(JText::_('PHOTOALBUM_FOLDERNOTFOUND').": {$path_local}");
   return false;
  }

  if ( !($dh = opendir($path_local)) )
  {
   $this->setError(JText::_('PHOTOALBUM_FOLDERNOTOPENED').": {$path_local}");
   return false;
  }

  $albums = array();
  $time = array();

  while (($filename = readdir($dh)) !== false)
  {
   $album = "{$path_local}{$filename}";
   if ( !is_dir($album) || preg_match('/^\./', $filename) ) continue;
   $time[$filename] = filemtime($album);
  }
  closedir($dh);
  arsort($time);

  foreach ($time as $filename => $ftime)
  {
   $album = "{$path_local}{$filename}";
   $album_cache = "{$path_thmb}{$filename}";
   if ( ($sdh = opendir($album)) )
   {
    while (($image = readdir($sdh)) !== false)
    {
     if ( !is_file("{$album}/{$image}" ) || !preg_match('/^[\S]+(\.jpg|\.png)$/i', $image) ) $image = false;
     else break;
    }
    closedir($sdh);
   }

   $readme = @file_get_contents("{$album}/readme.txt");
   if ( !empty($image) ) {
    $image = "{$album}/{$image}";
    $thmb = "{$album_cache}/{$image}";
    $thmb = is_file($thmb) ? $thmb : false;
    $title = @file_get_contents("{$image}.title.txt");
   }

   $albums[$filename] = array (
    'readme' => $readme,
    'image' => $image,
    'thmb' => @$thmb,
    'title' => @$title
   );
  }

  if ( empty($albums) )
  {
   $this->setError(JText::_('PHOTOALBUM_SUBFOLDERNOTFOUND').": {$path_local}");
   return false;
  }

  $readme = @file_get_contents("{$path_local}/readme.txt");

  return array('readme' => $readme, 'albums' => $albums/*, 'Itemid' => $this->Itemid*/);
 }

}
