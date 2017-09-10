<?php
defined('_JEXEC') or die('Restricted access');

if ( !empty($this->data['readme']) ) echo "<p class=\"readme\">{$this->data['readme']}</p>";

$cnt_col = 3;

/*
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
*/
echo "<div class=\"right\">".JText::_('PHOTOALBUM_HITS').": {$this->data['hits']}<br><a href=\"{$this->data['back']}\">".JText::_('PHOTOALBUM_BACK')."</a></div>";

echo "<table border=\"0\" align=\"center\" cellspacing=\"4\" cellpadding=\"4\">";

$col = 1;
foreach ($this->data['files'] as $param)
{
 switch ( $param['type'] )
 {
  case 'image':
  {
   if ( $col == 1 ) echo '<tr>';
   echo "<td class=\"tmb\">".
        "<a href=\"{$param['src']}\" data-rel=\"lightcase:image\" title=\"{$param['title']}\">".
        "<img src=\"{$param['thmb']}\" alt=\"{$param['alt']}\" title=\"{$param['title']}\" class=\"thmb image\">".
        "</a>";

   $col = ($col >= $cnt_col) ? 1 : $col+1;
  } break;

  case 'video':
  {
   echo "<td class=\"tmb\" colspan={$cnt_col}>".
        "<a href=\"{$param['src']}\" data-rel=\"lightcase:video\" title=\"{$param['title']}\">".
        "<img src=\"{$param['thmb']}\" alt=\"{$param['alt']}\" title=\"{$param['title']}\" class=\"thmb video\">".
        "</a>";
  } break;

 }
}
echo '</table>';

echo "<p class=\"back\"><a href=\"{$this->data['back']}\">".JText::_('PHOTOALBUM_BACK')."</a></p>";
