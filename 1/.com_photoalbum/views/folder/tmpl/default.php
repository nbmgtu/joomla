<?php
defined('_JEXEC') or die('Restricted access');

if ( count($this->folders) == 0 ) {
    echo '<p class="error">' . JText::_('PHOTOALBUM_SUBFOLDERNOTFOUND') . '</p>';
    return;
}
if ($this->readme) echo '<p class="readme">' . $this->readme . '</p>';

echo '<br><table border="0" align="center" cellspacing="4" cellpadding="4" width="95%">';

while ( list($name, list($readme, $img)) = each($this->folders) ) {
    echo '<tr style="valign: middle;">';
    echo '<td class="tmb">';
    echo '<a href="index.php?option=com_photoalbum&view=items&folder=' . $name . '&Itemid=' . $this->Itemid . '">';
    if ( $img ) echo '<img src="' . $this->path_inet . $name . '/' . $img . '" width="150">';
	else echo $name;
    echo '</a>';
    echo '<td class="comment">';
    echo $readme;
}
echo '</table>';
?>