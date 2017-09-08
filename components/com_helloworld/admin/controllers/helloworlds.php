<?php
// No direct access to this file
defined('_JEXEC') or die('Restricted access');

// HelloWorlds Controller
class HelloWorldControllerHelloWorlds extends JControllerAdmin
{
    // Proxy for getModel
    public function getModel($name = 'HelloWorld', $prefix = 'HelloWorldModel', $config = array('ignore_request' => true))
    {
	$model = parent::getModel($name, $prefix, $config);

	return $model;
    }
}
