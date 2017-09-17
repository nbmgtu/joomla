<?php
defined('_JEXEC') or die('Restricted access');
?>
<div class="headertable">
 <div class="owl-carousel">
<?php
foreach ($files as $file)
{
 echo "<a href=\"{$file}\" data-rel=\"lightcase:owl-carousel\"><img src=\"{$file}\" /></a>";
}
?>

</div></div>
