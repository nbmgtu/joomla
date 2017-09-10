<?php
defined('_JEXEC') or die('Restricted access');

$mode = urlencode(trim(@$_REQUEST['mode']));
$kurs = urlencode(trim(@$_REQUEST['kurs']));
$facultet = urlencode(trim(@$_REQUEST['facultet']));

?>
<div class="content"><div class="Post"><div class="Post-body"><div class="Post-inner">
<h2 class="PostHeaderIcon-wrapper"><span class="PostHeader"><div class="componentheading">Список задолжников</div></span></h2>
<div class="PostContent">

<?= file_get_contents("http://192.168.5.1/report_chit.php?external=1&mode={$mode}&kurs={$kurs}&facultet={$facultet}") ?>

</div>
</div></div></div></div>
