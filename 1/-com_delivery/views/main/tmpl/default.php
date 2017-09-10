<?php
defined('_JEXEC') or die('Restricted access');

$user =& JFactory::getUser();
$userID = intval($user->get('id'));
$userMail = $user->get('email');

echo "<p class=readme><b>Рассылка для [$userMail]</b></p>";

echo '<form method=post>';
echo '<table border="0" align="center" cellspacing="4" cellpadding="4" class="delivery">';

$template_group_id = -1;
foreach ($this->db_templates as $template) {
 $templateID = intval($template['id']);
 $intervalID = intval($template['interval_id']);

 if ( $template_group_id != $template['template_group_id'] ) {
  echo "<tr><th colspan=2>{$template['title_group']}";
  $template_group_id = $template['template_group_id'];
 }

 echo "<tr>";
 echo "<td>{$template['title']}";
 echo "<td><select name='delivery_template[{$templateID}]'><option value=0>ОТКЛЮЧИТЬ";
 reset($this->db_intervals);
 foreach ($this->db_intervals as $data) {
  $selected = $data['id'] == $intervalID ? 'selected' : '';
  echo "<option value='{$data['id']}' {$selected}>{$data['title']}";
 }
 echo "</select>";
}

echo '<tr><td colspan=2 align=right><input type=submit value="СОХРАНИТЬ">';
echo '</table></form>';

?>