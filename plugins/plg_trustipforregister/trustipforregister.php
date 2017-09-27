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
  if ( !$usersConfig->get('allowUserRegistration')  )
  {
   $clientIP = $application->input->server->get('REMOTE_ADDR', '');

   // enable auto registration for learn-mgtu server
   $learnMGTUIP = $this->params->get('learnmgtuip', '');
   if ( !empty($clientIP) && !empty($learnMGTUIP) && ($clientIP == $learnMGTUIP) )
   {
    $usersConfig->set('allowUserRegistration', 1); // enable user registration
    $usersConfig->set('useractivation', 0); // set type activation - auto
    $usersConfig->set('mail_to_admin', 1); // enable send email to admin
    return;
   }

   // enable user registration for trust ip
   $trustip = trim($this->params->get('trustip', ''));
   if ( !empty($trustip) )
   {
    foreach(explode("\n", $trustip) as $CIDR)
    {
     if ( $this->ipCIDRCheck($clientIP, $CIDR) )
     {
      $usersConfig->set('allowUserRegistration', 1); // enable user registration
      $usersConfig->set('useractivation', 1); // set type activation - user
      $usersConfig->set('mail_to_admin', 0); // disable send email to admin
      return;
     }
    }
   }
  }
 }

 public function __construct(&$subject, $config) { parent::__construct($subject, $config); }

}
