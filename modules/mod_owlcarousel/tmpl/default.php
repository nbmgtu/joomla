<?php
defined('_JEXEC') or die('Restricted access');
?>
<div class="headertable"><div class="owl-carousel">
<?php
foreach ($images as $image)
{
 echo "<a href=\"{$image['image']}\" data-rel=\"lightcase\"><img src=\"{$image['thmb']}\" /></a>";
}
?>
</div></div>
