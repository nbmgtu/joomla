<?php
defined('_JEXEC') or die;

function journalBuildRoute(&$query)
{
 $segments = array();

 if (isset($query['view']))
 {
  $segments[] = $query['view'];
  unset($query['view']);
 }
 else if (isset($query['issue']))
 {
  $segments[] = $query['issue'];
  unset($query['issue']);
 }

 return $segments;
}

function journalParseRoute($segments)
{
 $vars = array();

 if ( !empty($segments[0]) ) $vars['view'] = $segments[0];
 if ( !empty($segments[1]) ) $vars['issue'] = $segments[1];

 return $vars;
}
