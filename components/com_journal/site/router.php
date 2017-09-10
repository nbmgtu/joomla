<?php
defined('_JEXEC') or die;

function journalRoute(&$query)
{
 $segments = array();
/*
print_r($query);
 if (isset($query['kurs']))
 {
  $segments[] = $query['kurs'];
  unset($query['kurs']);
 }
 else if (isset($query['facultet']))
 {
  $segments[] = $query['facultet'];
  unset($query['facultet']);
 }
 else if (isset($query['mode']))
 {
  $segments[] = $query['mode'];
  unset($query['mode']);
 }
*/
 return $segments;
}

function journalParseRoute($segments)
{
 $vars = array();
/*
 if ( count($segments) != 3 ) return $vars;

// $vars['view'] = 'files';
 $vars['kurs'] = $segments[0];
 $vars['facultet'] = $segments[1];
 $vars['mode'] = $segments[2];
*/
 return $vars;
}
