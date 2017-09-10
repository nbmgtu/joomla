<?php
// No direct access to this file
defined('_JEXEC') or die('Restricted access');

// HelloWorlds View
class HelloWorldViewHelloWorlds extends JViewLegacy
{
    // Display the Hello World view
    function display($tpl = null)
    {
	// Get data from the model
	$this->items		= $this->get('Items');
	$this->pagination	= $this->get('Pagination');

	// Check for errors.
	if (count($errors = $this->get('Errors')))
	{
	    JError::raiseError(500, implode('<br />', $errors));

	    return false;
	}

	// Set the toolbar
	$this->addToolBar();

	// Display the template
	parent::display($tpl);
    }

    // Add the page title and toolbar.
    protected function addToolBar()
    {
	JToolbarHelper::title(JText::_('COM_HELLOWORLD_MANAGER_HELLOWORLDS'));
	JToolbarHelper::addNew('helloworld.add');
	JToolbarHelper::editList('helloworld.edit');
	JToolbarHelper::deleteList('', 'helloworlds.delete');
    }
}
