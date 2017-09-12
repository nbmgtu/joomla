<?php
defined( '_JEXEC' ) or die( 'Restricted access' );

class JournalView extends JViewLegacy
{

 function ShowLangPage(&$content, $logo = false)
 {
  if ( ($content['ru'] != '') && ($content['en'] != '') ) {

   echo '<div id="page_ru" style="display: block" align="justify">';
   echo '<a href="javascript:getEN();">'.JText::_('COM_JOURNAL_ENGLISH').'</a>';
   echo '<br>';
   if ($logo) echo '<br><img src="'.$logo.'" style="padding-right: 10px;" align="left" border="0">';
   echo '<p align="justify">'.$content['ru'].'</p></div>';

   echo '<div id="page_en" style="display: none">';
   echo '<a href="javascript:getRU();">'.JText::_('COM_JOURNAL_RUSSIAN').'</a>';
   echo '<br>';
   if ($logo) echo '<br><img src="'.$logo.'" style="padding-right: 10px;" align="left" border="0">';
   echo '<p align="justify">'.$content['en'].'</p></div>';

  } else {
   if ( $content['ru'] != '' ) {
    if ($logo) echo '<br><img src="'.$logo.'" style="padding-right: 10px;" align="left" border="0">';
    echo $content['ru'];
   }
   else if ( $content['en'] != '' ) {
    if ($logo) echo '<br><img src="'.$logo.'" style="padding-right: 10px;" align="left" border="0">';
    echo $content['en'];
   }
  }
 }

 function display($tpl = null)
 {
  $this->data = $this->get('Data');

  if (count($errors = $this->get('Errors')))
  {
   JLog::add(implode('<br />', $errors), JLog::WARNING, 'jerror');
   return false;
  }

  parent::display($tpl);
 }
}
