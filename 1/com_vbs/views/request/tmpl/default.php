<?php
defined('_JEXEC') or die('Restricted access');

?>
<div class="content"><div class="Post"><div class="Post-body"><div class="Post-inner">
<h2 class="PostHeaderIcon-wrapper"><span class="PostHeader"><div class="componentheading">Виртуальная библиографическая служба</div></span></h2>
<div class="PostContent">

<p class="caption"><b><?= $this->db_topic['name']; ?></b></p><p><?= $this->db_topic['description']; ?></p>
<?php

 if ( isset($this->db_request) ) {

  if ( $this->is_admin ) {

   $author = htmlspecialchars($this->db_request['author']);
   $email = htmlspecialchars($this->db_request['email']);
   $message = htmlspecialchars($this->db_request['message']);
   $answer = htmlspecialchars($this->db_request['answer']);

?>

<p><?= $this->lastmessage; ?></p>
<form method=post action="index.php?option=com_vbs&view=request&topic=<?= $this->topic; ?>&request=<?= $this->request; ?>">
<fieldset>
<legend><?= $this->mode_edit_request; ?></legend>
<label>ФИО<br><input type=text name=author required value='<?= $author; ?>' maxlength=128 style="width: 100%"></label><br>
<label>e-mail<br><input type=text name=email required value='<?= $email; ?>' maxlength=128 style="width: 100%"></label><br>
<label>Вопрос<br><textarea name=message required maxlength=1024 style="width: 100%" rows=7><?= $message; ?></textarea></label><br>
<label>Ответ<br><textarea name=answer required style="width: 100%" rows=15><?= $answer; ?></textarea></label><br>
<p align=right><input type=submit name=mode value="<?= $this->mode_edit_request; ?>"></p>
</fieldset>
</form>

<?php

  } else {

   if ( $this->db_request['answer_dt'] == '0000-00-00 00:00:00' ) JError::raiseError(500, 'VBS_BAD_REQUEST_ID');

   echo "<b>Автор:</b> {$this->db_request['author']}<br>";
   echo "<b>Создано:</b> {$this->db_request['created']}<br>";
   echo "<b>Вопрос:</b> ".htmlspecialchars($this->db_request['message']).'<br>';
   echo "<br><b>Дата ответа</b> {$this->db_request['answer_dt']}<br>";
   echo "<b>Ответ:</b><br>{$this->db_request['answer']}<br>";

  }

 } else {

  echo '<ul>';
  foreach ($this->db_requests as $request) {

   $style = '';

   if ( $request['answer_dt'] == '0000-00-00 00:00:00' ) {
    if ( !$this->is_admin ) continue;
    else {
     $style = 'style="color: blue;"';
    }
   }

   $delete = $this->is_admin ? "<i><a href='/index.php?option=com_vbs&view=request&topic={$this->topic}&request={$request['id']}&mode=delete' onclick='return confirm(\"Удалить сообщение?\");'>(УДАЛИТЬ)</a></i>" : '';
   echo "<li><a href=\"index.php?option=com_vbs&view=request&topic={$this->topic}&request={$request['id']}\" {$style}><i>{$request['author']}; {$request['created']}</i><br>".htmlspecialchars($request['message'])."</a> {$delete}</li>";
  }
  echo '</ul>';
 }

 // yandex captcha
 if ( ($captcha = $this->YandexCaptchaQuery('get-captcha'/*, array('type' => 'latm')*/)) ) {

  $author = $email = '';

  $user =& JFactory::getUser();
  if ( !$user->guest ) {
   $author = htmlspecialchars($user->name);
   $email = htmlspecialchars($user->email);
  }
?>
<p><?= $this->lastmessage; ?></p>
<form method=post action="index.php?option=com_vbs&view=request&topic=<?= $this->topic; ?>">
<input type=hidden name=ccaptcha value="<?= $captcha->captcha; ?>">
<fieldset>
<legend><?= $this->mode_append_request; ?></legend>
<label>ФИО<br><input type=text name=author required value='<?= $author; ?>' maxlength=128 style="width: 100%"></label><br>
<label>e-mail<br><input type=text name=email required value='<?= $email; ?>' maxlength=128 style="width: 100%"></label><br>
<label>Вопрос<br><textarea name=message required maxlength=1024 style="width: 100%" rows=7></textarea></label><br>
<label>Каптча<br><img src="<?= $captcha->url; ?>" width="200px" height="60px" align="left"><input type=text name=cvalue required style="height: 60px; width: 250px; font: bold 40px serif;"></label><br><br>
<p align=right><input type=submit name=mode value="<?= $this->mode_append_request; ?>"></p>
</fieldset>
</form>

<?php

 } else echo '<p><b>Добавление вопроса верменно невозможно</b></p>';


?>

</div>
</div></div></div></div>
