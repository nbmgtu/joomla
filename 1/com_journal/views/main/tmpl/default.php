<?php
defined('_JEXEC') or die('Restricted access');

$this->link_editorialboard = "index.php?option=com_journal&view=editorialboard&Itemid={$this->itemid}";
$this->link_issues = "index.php?option=com_journal&view=issues&Itemid={$this->itemid}";
$this->link_informationforauthors = "index.php?option=com_journal&view=informationforauthors&Itemid={$this->itemid}";

$this->link_logo = "{$this->folder_inet}/logo.jpg";

$content = array(
 'ru' => file_get_contents("{$this->folder_local}/description_ru.htm"),
 'en' => file_get_contents("{$this->folder_local}/description_en.htm")
);

?>
<div class="content"><div class="Post"><div class="Post-body"><div class="Post-inner">
<h2 class="PostHeaderIcon-wrapper"><span class="PostHeader"><div class="componentheading"><?= $this->title; ?></div></span></h2>
<div class="PostContent">
<ul class="ul-menu-categories">
<li><a href="<?= $this->link_editorialboard; ?>" class="category">Редколлегия</a></li>
<li><a href="<?= $this->link_issues; ?>" class="category">Выпуски журнала</a></li>
<li><a href="<?= $this->link_informationforauthors; ?>" class="category">Информация для авторов</a></li>
</ul>
<br>

<?= $this->ShowLangPage($content, $this->link_logo); ?>

</div>
</div></div></div></div>