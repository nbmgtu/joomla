<?php
defined('_JEXEC') or die('Restricted access');

$cnt_col = 3;

if ($this->readme) echo '<p class="readme">' . $this->readme . '</p>';

if ( $this->hasParent ) {
    if ( count($this->audios) > 0 ) {
      echo '<div class="left"><audio onended="audio_end(this)" controls autoplay preload src="'.$this->audios[0].'"></audio></div>';
      echo '<script>';
      echo 'AUDIO_SRC = new Array("'.implode('", "', $this->audios).'");';
echo '
AUDIO_CURRENT = 0;
AUDIO_LENGTH = AUDIO_SRC.length;
function audio_end(obj) {
 if (++AUDIO_CURRENT >= AUDIO_LENGTH) AUDIO_CURRENT = 0;
 obj.src = AUDIO_SRC[AUDIO_CURRENT];
};
</script>';
    }
    echo '<div class="right">'.JText::_('PHOTOALBUM_HITS').': '.$this->hits.'<br><a href="index.php?option=com_photoalbum&view=folder&Itemid=' . $this->Itemid . '">' . JText::_('PHOTOALBUM_BACK') . '</a></div>';
}

if ( count($this->images) > 0 ) {
    echo '<table border="0" align="center" cellspacing="4" cellpadding="4">';

    $col = 1;
    while ( list($name, list($type, $alt, $title)) = each($this->images) ) {

	if ( $type == 'image' ) {

  	  if ( $col == 1 ) echo '<tr>';
          echo '<td class="tmb">';

	  echo '<a href="' . $this->path_inet . $name . '" class="highslide slow" onclick="return hs.expand(this, grGalleryOptions)">';
	  echo '<img src="' . $this->path_inet . 'tmb_' . $name . '" alt="' . $alt . '" title="' . $title . '">';
	  echo '</a>';

  	  $col = ($col >= $cnt_col) ? 1 : $col+1;
        }
        else if ( $type == 'video' ) {

          echo "<tr><td class=tmb colspan={$cnt_col}>";
          echo '<video src="' . $this->path_inet . $name . '" width="480" controls preload="none" poster="' . $this->path_inet . 'tmb_' . $name . '"></video>';
        }

    }
    echo '</table>';

    if ( $this->hasParent ) {
	echo '<p class="back"><a href="index.php?option=com_photoalbum&view=folder&Itemid=' . $this->Itemid . '">' . JText::_('PHOTOALBUM_BACK') . '</a></p>';
    }
} else {
    echo '<p class="error">' . JText::_('PHOTOALBUM_IMAGESNOTFOUND') . '</p>';
}

?>