<?php
defined('_JEXEC') or die('Restricted access');
?>
<div class="content"><div class="Post"><div class="Post-body"><div class="Post-inner">
<h2 class="PostHeaderIcon-wrapper"><span class="PostHeader"><div class="componentheading"><?= $this->title; ?>
</div></span></h2>
<div class="PostContent">
<p class="caption"><b>Выпуски журнала</b></p>
<p>На данный момент вы можете получить полные тексты всех статей, опубликованных в выпусках:</p>

<table border=0 class="issues">
<tr><th>#<th>Выпуск<th>Просмотров
<?php
 $pattern = "/^([0-9]{4})-([0-9]{2})$/";
 $i = 0;
 $items = scandir($this->folder_local, 1);
 foreach ($items as $name) {
  if ( !preg_match($pattern, $name, $matches) || !is_dir("{$this->folder_local}/{$name}") ) continue;

  $year = intval($matches[1]);
  $number = intval($matches[2]);
  $hits = intval(file_get_contents("{$this->folder_local}/{$name}/hits"));
  $link = "index.php?option=com_journal&view=folder&Itemid={$this->itemid}&folder={$name}";

  $i++;
  echo "<tr><td>{$i}<td><a href=\"{$link}\">{$this->title}, выпуск {$number} ({$year})</a><td align=right>{$hits}";
 }
?>
</table>

</div>
</div></div></div></div>