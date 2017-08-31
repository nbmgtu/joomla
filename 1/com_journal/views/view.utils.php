<?php
class UtilsView extends JView
{
 function ShowLangPage(&$content, $logo = false)
 {
  if ( ($content['ru'] != '') && ($content['en'] != '') ) {

   echo '<div id="page_ru" style="display: block" align="justify">';
   echo '<a href="javascript:getEN();">ENGLISH</a>';
   echo '<br>';
   if ($logo) echo '<br><img src="'.$logo.'" style="padding-right: 10px;" align="left" border="0">';
   echo '<p align="justify">'.$content['ru'].'</p></div>';

   echo '<div id="page_en" style="display: none">';
   echo '<a href="javascript:getRU();">Русский</a>';
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
}
