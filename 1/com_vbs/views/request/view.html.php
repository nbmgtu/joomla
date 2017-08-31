<?php
defined('_JEXEC') or die('Restricted access');

jimport( 'joomla.application.component.view');

class VbsViewRequest extends JView
{
 function display($tpl = null)
 {
  $this->loadArrays();
  parent::display($tpl);
 }

 function SendMail($email, $subject, $message)
 {
  $EOL = "\n";
  $boundary = md5(uniqid(time()));
  $headers  = "MIME-Version: 1.0;{$EOL}";
  $headers .= "Content-Type: multipart/mixed; boundary=\"$boundary\"{$EOL}";
  $multipart  = $EOL;
  $multipart .= "--{$boundary}{$EOL}";
  $multipart .= "Content-Type: text/plain; charset=UTF-8{$EOL}";
  $multipart .= "Content-Transfer-Encoding: base64{$EOL}";
  $multipart .= $EOL;
  $multipart .= chunk_split(base64_encode($message)).$EOL;
  $multipart .= $EOL;
//  $multipart .= "--{$boundary}{$EOL}";
  $multipart .= "--{$boundary}--{$EOL}";

  return !mail($email, '=?UTF8?B?'.base64_encode($subject).'?=', $multipart, $headers);
 }

 function YandexCaptchaQuery($bin, $parameters = array(), $post = false)
 {
  $server = 'http://cleanweb-api.yandex.ru/1.0/';
  $key = 'cw.1.1.20140706T135631Z.9fc7270749f45be9.319d8eb831e41f734dfd6af7dac5ee0501dbdb9a';

  if ( !isset($parameters['key']) ) $parameters['key'] = $key;

   $parameters_query = http_build_query($parameters);

   $http_options = array ( 'http' => array ( 'timeout' => 10) );

   if ( $post ) {

    $http_options['http']['method'] = 'POST';
    $http_options['http']['content'] = $parameters_query;
    $url = "{$server}{$bin}";

   } else $url = "{$server}{$bin}?{$parameters_query}";

   $context = stream_context_create($http_options);
   $contents = file_get_contents($url, false, $context);

   if ( !$contents ) return false;

   return new SimpleXMLElement($contents);
 }

 function loadArrays()
 {
  $lastmessage = '';
  $mode_append_request = 'Добавить новый вопрос';
  $mode_edit_request = 'Ответить';
  $mode_drop_request = 'Удалить';

  $this->assignRef('mode_append_request', $mode_append_request);
  $this->assignRef('mode_edit_request', $mode_edit_request);
  $this->assignRef('mode_drop_request', $mode_drop_request);

  $db = JFactory::getDBO();

  $query =
   'SELECT name, description '.
   'FROM #__vbs_topics '.
   "WHERE id = {$this->topic}";
  $db->setQuery($query);
  if ( !$db->query() ) JError::raiseError(500, $db->stderr(true));
  $topic = $db->loadAssoc();
  if ( !$topic ) JError::raiseError(500, JText::_('VBS_BAD_TOPIC_ID'));
  $this->assignRef('db_topic', $topic);


  if ( $this->mode == 'delete' ) { // удаление сообщения

   $query =
    'DELETE FROM #__vbs_requests '.
    "WHERE id = {$this->request} AND topic = {$this->topic}";
   $db->setQuery($query);
   if ( !$db->query() ) JError::raiseError(500, $db->stderr(true));

   $this->request = 0;
   $lastmessage = '<b><font color=green>Сообщение успешно удалено</font></b>';

  }
  else if ( $this->mode == $mode_edit_request ) { // модерация

   $author = mysql_real_escape_string($this->newrequest['author']);
   $email = mysql_real_escape_string($this->newrequest['email']);
   $message = mysql_real_escape_string($this->newrequest['message']);
   $answer = mysql_real_escape_string($this->newrequest['answer']);

   $query =
    'UPDATE #__vbs_requests '.
    "SET author = '{$author}', email = '{$email}', message = '{$message}', answer_dt = NOW(), answer = '{$answer}' ".
    "WHERE id = {$this->request} AND topic = {$this->topic}";
   $db->setQuery($query);
   if ( !$db->query() ) JError::raiseError(500, $db->stderr(true));

   $mail = $this->SendMail($email, 'Ответ на заданный Вами вопрос на сайте библиотеки МГТУ', "Вопрос: {$message}\n\nОтвет: {$answer}") ? 'письмо НЕ отправлено' : 'письмо отправлено';

   $this->request = 0;
   $lastmessage = "<b><font color=green>Сообщение успешно сохранено, {$mail}</font></b>";

  }
  else if ( $this->mode == $mode_append_request ) { // добавляем вопрос на модерацию

   // проверяем captcha
   if ( ($captcha = $this->YandexCaptchaQuery('check-captcha', array('captcha' => $this->captcha['id'], 'value' => $this->captcha['value']))) && isset($captcha->ok) ) {

    $author = mysql_real_escape_string($this->newrequest['author']);
    $email = mysql_real_escape_string($this->newrequest['email']);
    $message = mysql_real_escape_string($this->newrequest['message']);

    $query =
     'INSERT INTO #__vbs_requests '.
     "SET topic = {$this->topic}, author = '{$author}', email = '{$email}', message = '{$message}'";
    $db->setQuery($query);
    if ( !$db->query() ) JError::raiseError(500, $db->stderr(true));

    $lastmessage = '<b><font color=green>Ваше сообщение успешно добавлено для модерации</font></b>';

   } else $lastmessage = '<b><font color=red>Ошибка ввода каптчи</font></b>';

  }

  $this->assignRef('lastmessage', $lastmessage);

  if ( $this->request ) {

   $query =
    'SELECT id, created, author, email, message, answer_dt, answer '.
    'FROM #__vbs_requests '.
    "WHERE id = {$this->request} AND topic = {$this->topic}";
   $db->setQuery($query);
   if ( !$db->query() ) JError::raiseError(500, $db->stderr(true));
   $request = $db->loadAssoc();
   if ( !$request ) JError::raiseError(500, JText::_('VBS_BAD_REQUEST_ID'));
   $this->assignRef('db_request', $request);

  } else {

   $query =
    'SELECT id, created, author, email, message, answer_dt '.
    'FROM #__vbs_requests '.
    "WHERE topic = {$this->topic} ".
    'ORDER BY answer_dt = "0000-00-00 00:00:00" DESC, answer_dt DESC';
   $db->setQuery($query);
   if ( !$db->query() ) JError::raiseError(500, $db->stderr(true));
   $this->assignRef('db_requests', $db->loadAssocList());

  }
 }

}
?>