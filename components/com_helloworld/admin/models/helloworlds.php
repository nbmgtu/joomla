<?php
defined('_JEXEC') or die('Restricted access');

class HelloWorldModelHelloWorlds extends JModelList
{
    protected function getListQuery()
    {
	$db    = JFactory::getDbo();
	$query = $db->getQuery(true);

	$query->select('*')
                ->from($db->quoteName('#__helloworld'));

	return $query;
    }
}