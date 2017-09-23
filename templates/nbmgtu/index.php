<?php
defined('_JEXEC') or die;

$application = JFactory::getApplication();
$document = JFactory::getDocument();
$menu = $application->getMenu();
$language = JFactory::getLanguage();
$config = JFactory::getConfig();

$template = "/templates/{$this->template}";

$document->addStyleSheet("{$template}/css/template.css");
$document->addStyleSheet('http://fonts.googleapis.com/css?family=Oswald:400,300');

$document->setMetaData("X-UA-Compatible", "IE=Edge", "http-equiv");

// JQuery
$document->addScript("{$template}/assets/jquery/jquery.min.js");

// JQuery-UI
$document->addStyleSheet("{$template}/assets/jquery-ui/jquery-ui.min.css");
$document->addScript("{$template}/assets/jquery-ui/jquery-ui.min.js");

// lightcase
$document->addStyleSheet("{$template}/assets/lightcase/css/lightcase.css");
$document->addScript("{$template}/assets/lightcase/js/lightcase.js");

// ?
$document->addScript('http://html5shiv.googlecode.com/svn/trunk/html5.js', array('conditional' => 'lt IE 9'));

// init event
$document->addScript("{$template}/js/main.js");

// $is_home_page = $menu->getActive() == $menu->getDefault($language->getTag());

//$this->setHtml5(true);


?>
<!doctype html>
<html>
 <head>
  <jdoc:include type="head"/>
 </head>
 <body>

  <div class="sitename"><?php echo $config->get('sitename'); ?></div>

  <div class="navigation">
   <div class="mainmenu">
    <jdoc:include type="modules" name="mainmenu"/>
   </div>
   <div class="fastbutton">
    <ul class="menu">
     <jdoc:include type="modules" name="fastbutton"/>
    </ul>
   </div>
  </div>

  <jdoc:include type="modules" name="header"/>

  <table class="main">
   <tr>
    <td class="left">
     <jdoc:include type="modules" name="left" style="moduletable"/>
    </td>

    <td class="content">
     <jdoc:include type="message"/>

     <?php /*if ($this->params->get('show_page_heading', FALSE)) : ?>
      <h1><?php echo $this->params->get('page_heading') ? $this->params->get('page_heading') : JFactory::getApplication()->getMenu()->getActive()->title; ?></h1>
     <?php endif; */?>

     <?php /* if ( !$is_home_page ): ?>
     <div class="caption">
      <h1><?php echo $this->getTitle(); ?></h1>
     </div>
     <?php endif; */ ?>

     <jdoc:include type="component"/>
    </td>

    <td class="right">
     <jdoc:include type="modules" name="right" style="moduletable"/>
    </td>
   </tr>
  </table>

  <footer>
   <jdoc:include type="modules" name="footer"/>
  </footer>

 </body>
</html>