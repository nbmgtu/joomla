<?php
defined( '_JEXEC' ) or die( 'Restricted access' );

jimport( 'joomla.application.component.view');

class PhotoAlbumViewFolder extends JView
{
    function display($tpl = null)
    {
	$this->loadArrayFolders();

	parent::display($tpl);
    }

    function loadArrayFolders()
    {
	$path_local = JPATH_BASE . DS . $this->folder;
	$path_inet = JURI::root(false) . $this->folder;
	$folders = array();
	$readme = file_get_contents($path_local . 'readme');


	if ( !is_dir($path_local) ) {
	    echo '<p class="error">' . JText::_('PHOTOALBUM_FOLDERNOTFOUND') . '</p>';
	    return;
	}

	if ( !($dh = opendir($path_local)) ) {
	    echo '<p class="error">' . JText::_('PHOTOALBUM_FOLDERNOTOPENED') . '</p>';
	    return;
	}

 $time = array();
 while (($filename = readdir($dh)) !== false) {
  $folder = $path_local.$filename;
  if ( !is_dir($folder) || preg_match('/^\./', $filename) ) continue;
  $time[$filename] = filemtime($folder);
 }
 closedir($dh);
 arsort($time);

 foreach ( $time as $filename => $ftime ) {
  $folder = $path_local.$filename;
  if ( ($sdh = opendir($folder)) ) {
   while (($img = readdir($sdh)) !== false) {
    if ( !is_file( $folder.'/'.$img ) || !preg_match('/^tmb_[\S]+(\.jpg|\.png)$/i', $img) ) continue;
    break;
   }
   closedir($sdh);
  }
  $folders[ $filename ] = array (
   0 => file_get_contents($folder.'/readme'),
   1 => $img
  );
 }

 $this->assignRef( 'path_inet', $path_inet );
 $this->assignRef( 'readme', $readme );
 $this->assignRef( 'folders', $folders );
 $this->assignRef( 'Itemid', $this->Itemid );
 }
}
?>
