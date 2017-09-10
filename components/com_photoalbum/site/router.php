<?php
defined('_JEXEC') or die;

function photoalbumBuildRoute(&$query)
{
 $segments = array();

 if (isset($query['album']))
 {
  $segments[] = $query['album'];
  unset($query['album']);
 }

 return $segments;
}

function photoalbumParseRoute($segments)
{
 $vars = array();

 if ( count($segments) != 1 ) return $vars;

 $vars['view'] = 'files';
 $vars['album'] = $segments[0];

 return $vars;
}
