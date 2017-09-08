<?php
defined('_JEXEC') or die('Restricted access');

if ( !empty($this->data['readme']) ) echo "<p class=\"readme\">{$this->data['readme']}</p>";

echo "<pre>";
print_r($this->data);
echo "</pre>";

echo '<br><table border="0" align="center" cellspacing="4" cellpadding="4" width="95%">';

foreach ($this->data['albums'] as $album => $param)
{
 echo '<tr style="valign: middle;">';
 echo '<td class="tmb">';
/*
 echo "<a href=\"{$this->data['folder']}{$album}/{$param['image']}\" data-rel=\"lightcase\" title=\"Your title\">";
 if ( !empty($img) ) echo '<img src="' . $this->path_inet . $name . '/' . $img . '" width="150">';
	else echo $name;
    echo '</a>';
*/
//  echo '<a href="index.php?option=com_photoalbum&view=items&folder=' . $name . '&Itemid=' . $this->data['Itemid'] . '">';
 echo "<td class=\"comment\"><a href=\"\">{$param['readme']}</a>";
}
echo '</table>';
