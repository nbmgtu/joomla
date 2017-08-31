<?php
defined( '_JEXEC' ) or die( 'Restricted access' );

jimport( 'joomla.plugin.plugin' );

class plgContentPdfbookcase extends JPlugin
{
 var $prefix = '/var/www/html';

 function plgContentPdfbookcase( &$subject, $params )
 {
  parent::__construct( $subject, $params );
 }

 function onPrepareContent( &$article, &$params, $limitstart )
 {
  // <pdfbookcase src="" max="0" />
  $regex = "#<pdfbookcase\s*[^>]*/>#i";

  preg_match_all($regex, $article->text, $matches);
  $count = count($matches[0]);

  if ( $count ) $article->text = $this->replace($article->text, $matches, $count);
 }

 function replace($input, &$matches, $count)
 {
  for ($i=0; $i < $count; $i++) {
   if ( @$matches[0][$i] ) {
    $title = $this->getAtt('title', $matches[0][$i]);
    $src = $this->getAtt('src', $matches[0][$i]);
    $max = intval($this->getAtt('max', $matches[0][$i]));

    $time = array();
    foreach (@glob("{$src}/*.pdf", GLOB_NOSORT) as $filename) {
     $fjpg = substr($filename, 0, strlen($filename)-3)."jpg";
     $freadme = substr($filename, 0, strlen($filename)-3)."txt";

     $time[$filename] = max(intval(@filemtime($filename)), intval(@filemtime($fjpg)), intval(@filemtime($freadme)));
    }

    if ( count($time) ) {
     arsort($time);

     $rowcount = 0;
     $dest = '';
     if ( $title != '' ) $dest .= '<p class="readme">﻿'.htmlspecialchars($title).'</p>';
     $dest .= '<table border="0" align="center" cellspacing="4" cellpadding="4" style="width: 95%">';
     foreach($time as $fname => $ftime) {
      if ( $max && ($rowcount++ >= $max) ) break;

      $fpdf = substr($fname, strlen($this->prefix));
      $fjpg = substr(substr($fname, 0, strlen($fname)-3)."jpg", strlen($this->prefix));
      $freadme = substr($fname, 0, strlen($fname)-3)."txt";
      $readme = @file_get_contents($freadme);

      $dest .= "<tr style='valign: middle;'><td class='tmb'><a href='{$fpdf}' target='_blank'><img src='{$fjpg}'></a></td><td class='comment'>{$readme}</td></tr>";
     }
     $dest .= '</table>';

     $input = str_replace($matches[0][$i], $dest, $input);
    }
   }
  }

  return $input;
 }

 function getAtt($att, $match)
 {
  $attValue = '';
  $attMatches = array();

  preg_match("#{$att}\s*=\s*['\"](.*)['\"]#Ui", $match, $attMatches);
  if ( isset($attMatches[1]) ) $attValue = trim($attMatches[1]);

  return $attValue;
 }

}
