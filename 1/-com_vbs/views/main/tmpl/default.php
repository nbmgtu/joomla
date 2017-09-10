<?php
defined('_JEXEC') or die('Restricted access');

?>
<div class="content"><div class="Post"><div class="Post-body"><div class="Post-inner">
<h2 class="PostHeaderIcon-wrapper"><span class="PostHeader"><div class="componentheading">Виртуальная библиографическая служба</div></span></h2>
<div class="PostContent">

<?php

 if ( count($this->db_topics) == 0 ) echo '<p class="error">'.JText::_('VBS_EMPTY_TOPIC_LIST').'</p>';
 else {
  echo '<ul class="ul-menu-categories">';
  foreach ($this->db_topics as $topic) {
   $edit = $this->is_admin ? "<i><a href='index.php?option=com_vbs&view=main&topic={$topic['id']}'>(РЕДАКТИРОВАТЬ)</a></i>" : '';
   echo "<li><a href=\"index.php?option=com_vbs&view=request&topic={$topic['id']}\" class='category'>{$topic['name']}</a> {$edit}</li>";
  }
  echo '</ul>';
 }

 $name = $description = '';

 if ( $this->is_admin ) {

  if ( $this->topic ) {

   $name = $this->db_topic['name'];
   $description = $this->db_topic['description'];
   $position = intval($this->db_topic['position']);
   $mode = $this->mode_edit_topic;

  } else $mode = $this->mode_append_topic;

?>
<p><?= $this->lastmessage; ?></p>
<form method=post action="index.php?option=com_vbs&view=main">
<input type=hidden name=topic value="<?= $this->topic; ?>">
<fieldset>
<legend><?= $mode; ?></legend>
<label>Наименование:<br><input type=text name=name required value='<?= $name; ?>' maxlength=255 style="width: 100%"></label><br>
<label>Описание:<br><textarea name=description required style="width: 100%" rows=7><?= $description; ?></textarea></label><br>
<label>Позиция:<br><input type=text name=position value='<?= $position; ?>' style="width: 100%"></label><br>
<p align=right><input type=submit name=mode value="<?= $mode; ?>"></p>
</fieldset>
</form>

<?php
 }

?>

</div>
</div></div></div></div>
