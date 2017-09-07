<?php
defined('_JEXEC') or die('Restricted access');

class HelloWorldModelHelloWorld extends JModelItem
{
    protected $message;

    public function getTable($type = 'HelloWorld', $prefix = 'HelloWorldTable', $config = array())
    {
	return JTable::getInstance($type, $prefix, $config);
    }

    public function getMsg($id = 1)
    {
	if (!is_array($this->messages))
	{
	    $this->messages = array();
	}

	if (!isset($this->messages[$id]))
	{
	    // Request the selected id
	    $jinput = JFactory::getApplication()->input;
	    $id     = $jinput->get('id', 1, 'INT');

	    // Get a TableHelloWorld instance
	    $table = $this->getTable();

	    // Load the message
	    $table->load($id);

	    // Assign the message
	    $this->messages[$id] = $table->greeting;
	}

	return $this->messages[$id];
    }
}
