<?php
defined('_JEXEC') or die;

function newsliteratureBuildRoute(&$query)
{
 $segments = array();

 if (isset($query['udk']))
 {
  $segments[] = $query['udk'];
  unset($query['udk']);
 }

 if (isset($query['type']))
 {
  $segments[] = $query['type'];
  unset($query['type']);
 }

 if (isset($query['period']))
 {
  $segments[] = $query['period'];
  unset($query['period']);
 }

 if (isset($query['page']))
 {
  $segments[] = $query['page'];
  unset($query['page']);
 }

 return $segments;
}

function newsliteratureParseRoute($segments)
{
 $vars = array();

 if ( count($segments) != 4 ) return $vars;

 $vars['udk'] = $segments[0];
 $vars['type'] = $segments[1];
 $vars['period'] = $segments[2];
 $vars['page'] = $segments[3];

 return $vars;
}
