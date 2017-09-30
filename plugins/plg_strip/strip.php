<?php
defined('_JEXEC') or die;

class PlgSystemStrip extends JPlugin
{
 public function __construct(&$subject, $config) { parent::__construct($subject, $config); }

 private function Filter(&$haystack, $name)
 {
  $params = trim($this->params->get($name, ''));
  if ( empty($params) ) return;

  $params = explode("\n", $params);
  foreach ($haystack as $_param => &$value)
  {
   $unset = true;
   foreach ($params as $param)
   {
    $param = trim($param);
    if ( empty($param) ) continue;

    if ( strpos($_param, $param) !== FALSE )
    {
     $unset = false;
     break;
    }
   }

   if ( $unset ) unset($haystack[$_param]);
  }
 }

 public function onBeforeCompileHead()
 {
  $application = JFactory::getApplication();
  if ( $application->isAdmin() ) return;

  $document = JFactory::getDocument();
  $document->_generator = 'nbmgtu';
  $document->_script = array();

  $this->Filter($document->_links, 'links');
  $this->Filter($document->_scripts, 'scripts');
  $this->Filter($document->_styleSheets, 'styleSheets');
 }

}
