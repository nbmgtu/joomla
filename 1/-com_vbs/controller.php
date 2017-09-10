<?php
defined('_JEXEC') or die('Restricted access');

jimport('joomla.application.component.controller');

class VbsController extends JController
{
	function display()
	{
		$document = &JFactory::getDocument();
		$document->addStyleSheet( JURI::root(true) . '/components/com_vbs/style.css' );

    $user =& JFactory::getUser();

    $view_name = JRequest::getCmd('view');
    $view =& $this->getView($view_name, 'html'); 

		$view->topic = JRequest::getInt('topic', 0);
		$view->request = JRequest::getInt('request', 0);
		$view->mode = JRequest::getString('mode', '');

    $view->is_admin = !$user->guest && ($user->get('usertype') != 'Registered');

		$view->captcha = array(
     'id' => JRequest::getString('ccaptcha', ''),
     'value' => JRequest::getString('cvalue', '')
    );

		$view->newrequest = array(
     'author' => JRequest::getString('author', ''),
     'email' => JRequest::getString('email', ''),
     'message' => JRequest::getString('message', ''),
     'answer' => JRequest::getString('answer', '', 'default', JREQUEST_ALLOWRAW)
    );

		$view->newtopic = array(
     'position' => JRequest::getInt('position', 0),
     'name' => JRequest::getString('name', ''),
     'description' => JRequest::getString('description', ''),
    );

	  $view->display();
	}
}
?>