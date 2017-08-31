<?php
defined('_JEXEC') or die('Restricted access');

$content = array(
 'ru' => @file_get_contents("{$this->folder_local}/informationforauthors_ru.htm"),
 'en' => @file_get_contents("{$this->folder_local}/informationforauthors_en.htm")
);

?>
<div class="content"><div class="Post"><div class="Post-body"><div class="Post-inner">
<h2 class="PostHeaderIcon-wrapper"><span class="PostHeader"><div class="componentheading"><?= $this->title; ?>
</div></span></h2>
<div class="PostContent">
<p class="caption"><b>Информация для авторов</b></p>

<?= $this->ShowLangPage($content); ?>

</div>
</div></div></div></div>