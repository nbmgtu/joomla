<?php
defined('_JEXEC') or die('Restricted access');

JFormHelper::loadFieldClass('list');

class JFormFieldHelloWorld extends JFormFieldList
{
    protected $type = 'HelloWorld';

    protected function getOptions()
    {
	$db    = JFactory::getDBO();
	$query = $db->getQuery(true);
	$query->select('id,greeting');
	$query->from('#__helloworld');
	$db->setQuery((string) $query);
	$messages = $db->loadObjectList();
	$options  = array();

	if ($messages)
	{
	    foreach ($messages as $message)
	    {
		$options[] = JHtml::_('select.option', $message->id, $message->greeting);
	    }
	}

	$options = array_merge(parent::getOptions(), $options);

	return $options;
    }
}