<?php
defined('_JEXEC') or die('Restricted access');

$udk = urlencode(@$_REQUEST['udk']);
$type = urlencode(@$_REQUEST['type']);
$period = urlencode(@$_REQUEST['period']);
$page = urlencode(@$_REQUEST['page']);

?>
<div class="content"><div class="Post"><div class="Post-body"><div class="Post-inner">
<h2 class="PostHeaderIcon-wrapper"><span class="PostHeader"><div class="componentheading">Новинки литературы</div></span></h2>
<div class="PostContent">

<?= file_get_contents("http://192.168.5.1/udk.php?page={$page}&udk={$udk}&type={$type}&period={$period}") ?>

</div>
</div></div></div></div>

