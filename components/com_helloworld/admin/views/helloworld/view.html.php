<?php
// No direct access to this file
defined('_JEXEC') or die('Restricted access');

// HelloWorld View
class HelloWorldViewHelloWorld extends JViewLegacy
{
    // View form
    protected $form = null;

    // Display the Hello World view
    public function display($tpl = null)
    {
	// Get the Data
	$this->form = $this->get('Form');
	$this->item = $this->get('Item');

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
	$input = JFactory::getApplication()->input;

	// Hide Joomla Administrator Main menu
	$input->set('hidemainmenu', true);

	$isNew = ($this->item->id == 0);

	if ($isNew)
	{
	    $title = JText::_('COM_HELLOWORLD_MANAGER_HELLOWORLD_NEW');
	}
	else
	{
	    $title = JText::_('COM_HELLOWORLD_MANAGER_HELLOWORLD_EDIT');
	}

	JToolbarHelper::title($title, 'helloworld');
	JToolbarHelper::save('helloworld.save');
	JToolbarHelper::cancel(
	    'helloworld.cancel',
	    $isNew ? 'JTOOLBAR_CANCEL' : 'JTOOLBAR_CLOSE'
	);
    }
}
