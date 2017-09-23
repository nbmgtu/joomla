<?php
defined('_JEXEC') or die;

class PlgSystemTrustipforregister extends JPlugin
{
 function ipCIDRCheck($IP, $CIDR)
 {
  @list($net, $mask) = explode("/", $CIDR);
  if ( empty($mask) ) $mask = 32;

  $ip_net = ip2long($net);
  $ip_mask = ~((1 << (32 - $mask)) - 1);

  $ip_ip = ip2long($IP);

  $ip_ip_net = $ip_ip & $ip_mask;

  return ($ip_ip_net == $ip_net);
 }

 public function onAfterInitialise()
 {
  $application = JFactory::getApplication();
  if ($application->isClient('administrator')) return;

  $usersConfig = JComponentHelper::getParams('com_users');
  if ( $usersConfig->get('allowUserRegistration')  )
  {
   $trustip = trim($this->params->get('trustip', ''));
   if ( !empty($trustip) )
   {
    foreach(explode("\n", $trustip) as $CIDR)
     if ( $this->ipCIDRCheck($_SERVER['REMOTE_ADDR'], $CIDR) ) return;

    $usersConfig->set('allowUserRegistration', 0);
   }
  }
 }

 public function __construct(&$subject, $config) { parent::__construct($subject, $config); }

}
