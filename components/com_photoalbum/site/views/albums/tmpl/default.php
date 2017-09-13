<?php
defined('_JEXEC') or die('Restricted access');

echo "<div class=\"photoalbum\">";

if ( !empty($this->data['readme']) ) echo "<p class=\"readme\">{$this->data['readme']}</p>";

echo '<br><table border="0" align="center" cellspacing="4" cellpadding="4" width="95%">';

foreach ($this->data['albums'] as $album => $param)
{
 echo '<tr style="valign: middle;">';
 echo '<td class="tmb">';
 echo "<a href=\"{$param['href']}\">".( empty($param['image_thmb']) ? $album : "<img src=\"{$param['image_thmb']}\" width=\"150\">" )."</a>";
 echo "<td class=\"comment\">{$param['readme']}";
}
echo '</table>';
echo '</div>';
