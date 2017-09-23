<?php
defined('_JEXEC') or die('Restricted access');

function appendTooltipItem($param, $value)
{
 $tooltip = "<b>{$param}</b>:<br><i>{$value}</i>";
 return $tooltip;
}

// CHECK SSID
function checkSSID($ssid, &$session, &$mkgtu)
{
 $context = stream_context_create(array('http' => array('method'  => 'GET', 'timeout' => 2)));
 $mkgtu = @file_get_contents("http://learn-mkgtu.ru/json.php?com=checkssid&ssid={$ssid}", false, $context);

 if ( !empty($mkgtu) )
 {
  if ( ($mkgtu = @json_decode($mkgtu, true)) )
  {
   if ( isset($mkgtu['err']) && ($mkgtu['err'] === 0) )
   {
    $session->set('mkgtu', array('time' => time() + 60, 'data' => $mkgtu, 'ssid' => $ssid));
    return;
   }
  }
 }

 $session->clear('mkgtu');
 unset($mkgtu);
}

$session = JFactory::getSession();

$ssid = @$_REQUEST['ssid'];
// http://lib.mkgtu.ru/?ssid=ed629a2f9858daf3fc06b5da89b2f0d1
if ( !empty($ssid) ) checkSSID($ssid, $session, $mkgtu);
else
{
 $mkgtu = $session->get('mkgtu');
 if ( $mkgtu )
 {
  if ( $mkgtu['time'] < time() ) checkSSID($mkgtu['ssid'], $session, $mkgtu);
  else $mkgtu = $mkgtu['data'];
 }
}

if ( !empty($mkgtu) ) {
 $document = JFactory::getDocument();
 $document->addStyleSheet("/modules/mod_learnmkgtu/css/main.css");
 $document->addScript("/modules/mod_learnmkgtu/js/script.js");

 $tooltip = "<div class=moduletable>";
 if ( !empty($mkgtu['student']) ) $tooltip .= "<div class=title>".JText::_('MOD_LEARNMKGTU_STUDENT')."</div>";

 $tooltip .= appendTooltipItem(JText::_('MOD_LEARNMKGTU_FIO'), $mkgtu['user']['fio']);
 $tooltip .= "<br>".appendTooltipItem(JText::_('MOD_LEARNMKGTU_EMAIL'), $mkgtu['user']['email']);
 if ( !empty($mkgtu['student']) ) {
  $tooltip .= "<br>".appendTooltipItem(JText::_('MOD_LEARNMKGTU_NUMZACH'), $mkgtu['student']['num_zach']);
  $tooltip .= "<br>".appendTooltipItem(JText::_('MOD_LEARNMKGTU_NUMSTUD'), $mkgtu['student']['num_stud']);
  $tooltip .= "<br>".appendTooltipItem(JText::_('MOD_LEARNMKGTU_KODPODGOTOVKI'), $mkgtu['student']['kod_podgotovki']);
  $tooltip .= "<br>".appendTooltipItem(JText::_('MOD_LEARNMKGTU_GROUP'), $mkgtu['student']['grupp']);
 }
 $tooltip .= "</div>";

 $tooltip = addslashes($tooltip);
} else return;

require JModuleHelper::getLayoutPath('mod_learnmkgtu', $params->get('layout', 'default'));
