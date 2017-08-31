<?php

// no direct access
defined( '_JEXEC' ) or die( 'Restricted access' );

jimport( 'joomla.application.component.view');

/**
 * HTML View class for the PhotoAlbum Component
 *
 * @package PhotoAlbum
 */

class photoalbumViewitems extends JView
{
    function display($tpl = null)
    {
	$this->loadArrayImages();
	$this->loadArrayAudios();

        // накручиваем просмотры
        $fname = JPATH_BASE.DS.substr($this->folder, 0, -1).'.hits';
        $hits = intval(file_get_contents($fname)) + 1;
        file_put_contents($fname, $hits);
	$this->assignRef('hits', $hits);

	parent::display($tpl);
    }

    function loadArrayImages()
    {
	$regex_img = '/\.jpg|\.png$/i';
	$regex_video = '/\.mov|\.mp4|\.m4v|\.flv|\.ogv|\.avi|\.mpg|\.mkv$/i';
	$regex_tmb = '/^tmb_/';
	$tmb_width = 150;
	$tmb_height = 150;
	$path_local = JPATH_BASE . DS . $this->folder;
	$path_inet = JURI::root(false) . $this->folder;
	$images = array();
	$videos = array();
	$readme = file_get_contents($path_local . 'readme');

	if ( !is_dir($path_local) ) {
	    echo JText::_('PHOTOALBUM_FOLDERNOTFOUND');
	    return;
	}
	if ( !($dh = opendir($path_local)) ) {
	    echo JText::_('PHOTOALBUM_FOLDERNOTOPENED');
	    return;
	}

        while (($filename = readdir($dh)) !== false) {
	    $fname = $path_local . $filename;

            if ( is_file($fname) && !preg_match($regex_tmb, $filename) ) {

  	      if ( preg_match($regex_img, $filename) ) {
 	        // preview
	        $tmb = $path_local . 'tmb_' . $filename;
	        if ( !is_file($tmb) ) $this->create_tmb( $fname, $tmb, $tmb_width, $tmb_height );

 	        $images[ $filename ] = array(
 		  0 => 'image',
		  1 => file_get_contents($fname . '.alt'),
		  2 => file_get_contents($fname . '.title')
	        );

	      }
  	      else if ( preg_match($regex_video, $filename) ) {

 	        $videos[ $filename ] = array(
 		  0 => 'video',
		  1 => file_get_contents($fname . '.alt'),
		  2 => file_get_contents($fname . '.title')
	        );

	      }

	    }

	}
	closedir($dh);

	$this->assignRef( 'path_inet', $path_inet );
	$this->assignRef( 'readme', $readme );
	$this->assignRef( 'tmb_width', $tmb_width );
	$this->assignRef( 'tmb_height', $tmb_height );
	$this->assignRef( 'images', array_merge($images, $videos) );
	$this->assignRef( 'hasParent', $this->hasParent );
	$this->assignRef( 'Itemid', $this->Itemid );
    }

    function loadArrayAudios()
    {
	$regex_audio = '/\.mp3$/i';
	$path_local = JPATH_BASE . DS . $this->folder;
	$path_inet = JURI::root(false) . $this->folder;
	$audios = array();

	if ( !is_dir($path_local) ) {
	    echo JText::_('PHOTOALBUM_FOLDERNOTFOUND');
	    return;
	}
	if ( !($dh = opendir($path_local)) ) {
	    echo JText::_('PHOTOALBUM_FOLDERNOTOPENED');
	    return;
	}

        while (($filename = readdir($dh)) !== false) {
	    $fname = $path_local . $filename;
            if ( is_file($fname) && preg_match($regex_audio, $filename) ) $audios[] = $path_inet.$filename;
	}
	closedir($dh);

	$this->assignRef( 'audios', $audios );
    }

    function create_tmb( $source_pic, $destination_pic, $max_width, $max_height )
    {
	$src = imagecreatefromstring(file_get_contents($source_pic));
	list($width, $height) = getimagesize($source_pic);

	$x_ratio = $max_width / $width;
	$y_ratio = $max_height / $height;

	if ( ($width <= $max_width) && ($height <= $max_height) ) {
	    $tn_width = $width;
	    $tn_height = $height;
	} elseif ( ($x_ratio * $height) < $max_height ) {
	    $tn_height = ceil($x_ratio * $height);
	    $tn_width = $max_width;
	} else {
	    $tn_width = ceil($y_ratio * $width);
	    $tn_height = $max_height;
	}
	$tmp = imagecreatetruecolor($tn_width, $tn_height);
	imagecopyresampled($tmp, $src, 0, 0, 0, 0, $tn_width, $tn_height, $width, $height);

	switch ( strtolower(substr($destination_pic, -3, 3)) ) {
	  case 'jpg': imagejpeg($tmp, $destination_pic, 75); break;
	  case 'png': imagepng($tmp, $destination_pic, 7); break;
	}

	imagedestroy($src);
	imagedestroy($tmp);
    }
}
?>
