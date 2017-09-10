<?php
defined('_JEXEC') or die('Restricted access');

if ( !$this->issue_folder ) JError::raiseError(500, "Запрещенная папка: {$this->issue_folder}");

// накручиваем просмотры
$fname = "{$this->folder_local}/{$this->issue_folder}/hits";
$hits = intval(file_get_contents($fname)) + 1;
file_put_contents($fname, $hits);

$content = array('ru' => '', 'en' => '');

function ParseData(&$folder_local, &$folder_inet, &$issue_folder, &$content)
{
 reset($content);
 foreach ($content as $lang => &$body) {

  $data = file("{$folder_local}/{$issue_folder}/content_{$lang}.txt", FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
  if ( $data == '' ) continue;

  $fid = 0;
  $open = false;
  $haspage = false;

  foreach ($data as $line) {
   if ( $line[0] == "\t") $fid++;

   if ( $line[0] != "\t" ) {
    if ( $open ) $body .= "</ul></div>";
    $body .= "<p class=\"jheader\">{$line}</p><div><ul class=\"%HASPAGE%\" style=\"text-align: justify;\">";
    $open = true;
   } else {
    $tmp = explode('|', $line, 3);
    $author = trim($tmp[0]);
    $name = trim($tmp[1]);
    $page = trim(@$tmp[2]);
    if ( !empty($page) ) $haspage = true;
    $fname = sprintf('%03d', $fid);
    $body .= "<li><span class=\"text\"><a href=\"{$folder_inet}/{$issue_folder}/{$fname}.pdf\" target=\"_blank\"><b>{$author}</b> {$name}</a></span><span class=\"page\">{$page}</span></li>";
   }

  }
  $body .= "</ul></div>";
  $body = str_replace("%HASPAGE%", ($haspage ? "oglavl" : ""), $body);
 }
}

ParseData($this->folder_local, $this->folder_inet, $this->issue_folder, $content);

?>
<div class="content"><div class="Post"><div class="Post-body"><div class="Post-inner">
<h2 class="PostHeaderIcon-wrapper"><span class="PostHeader"><div class="componentheading"><?= $this->title; ?>, выпуск <?= $this->issue_number; ?> (<?= $this->issue_year; ?>)
</div></span></h2>
<div class="PostContent">
<br>

<?= $this->ShowLangPage($content); ?>

</div>
</div></div></div></div>