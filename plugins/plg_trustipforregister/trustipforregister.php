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
  if ( $application->isAdmin() ) return;

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


    $user = @$_REQUEST['learnmgtu-createuser'];
    if ( !empty($user) && is_array($user) )
    {
echo "<pre>";
print_r($user);


//    $lang = JFactory::getLanguage();
//    $extension = 'com_users';
//    $base_dir = JPATH_SITE;
//    $language_tag = 'en-GB';
//    $reload = true;
//    $lang->load($extension, $base_dir, $language_tag, $reload);

    // load the user regestration model
    $model = self::getModel('registration', JPATH_ROOT. '/components/com_users', 'Users');
    // set password
    $password = self::randomkey(8);
    // linup new user data
    $data = array(
        'username' => $new['username'],
        'name' => $new['name'],
        'email1' => $new['email'],
        'password1' => $password, // First password field
        'password2' => $password, // Confirm password field
        'block' => 0 );
    // register the new user
    $userId = $model->register($data);
    // if user is created
    if ($userId > 0)
    {
        return $userId;
    }
    return $model->getError();

die();
    }




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
