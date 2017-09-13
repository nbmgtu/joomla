<?php
defined('_JEXEC') or die;

function debtsBuildRoute(&$query)
{
 $segments = array();

 if (isset($query['kurs']))
 {
  $segments[] = $query['kurs'];
  unset($query['kurs']);
 }

 if (isset($query['facultet']))
 {
  $segments[] = $query['facultet'];
  unset($query['facultet']);
 }

 if (isset($query['mode']))
 {
  $segments[] = $query['mode'];
  unset($query['mode']);
 }

 return $segments;
}

function debtsParseRoute($segments)
{
 $vars = array();

 if ( count($segments) != 3 ) return $vars;

 $vars['kurs'] = $segments[0];
 $vars['facultet'] = $segments[1];
 $vars['mode'] = $segments[2];

 return $vars;
}
