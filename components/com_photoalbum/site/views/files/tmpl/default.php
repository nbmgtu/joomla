<?php
defined('_JEXEC') or die('Restricted access');

echo "<div class=\"photoalbum\">";
if ( !empty($this->data['readme']) ) echo "<p class=\"readme\">{$this->data['readme']}</p>";

$cnt_col = 3;

echo "<div class=\"right\">".JText::_('COM_PHOTOALBUM_HITS').": {$this->data['hits']}<br><a href=\"{$this->data['back']}\">".JText::_('COM_PHOTOALBUM_BACK')."</a></div>";

//if ( !empty($this->audios) ) echo '<div class="left"><audio onended="audio_end(this)" controls autoplay preload src="'.$this->audios[0].'"></audio></div>';
if ( !empty($this->audios) ) echo '<div class="left"><audio id="photoalbom" onended="audio_end(this)" controls autoplay preload></audio></div>';

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

echo "<p class=\"back\"><a href=\"{$this->data['back']}\">".JText::_('COM_PHOTOALBUM_BACK')."</a></p>";
echo "</div>";