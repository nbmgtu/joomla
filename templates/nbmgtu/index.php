<?php
defined('_JEXEC') or die;

$application = JFactory::getApplication();
$document = JFactory::getDocument();
$menu = $application->getMenu();
$language = JFactory::getLanguage();

$template = "/templates/{$this->template}";

$document->addStyleSheet("{$template}/css/template.css");
$document->addStyleSheet('http://fonts.googleapis.com/css?family=Oswald:400,300');

$document->setMetaData("X-UA-Compatible", "IE=Edge", "http-equiv");
$document->addScript('http://html5shiv.googlecode.com/svn/trunk/html5.js', array('conditional' => 'lt IE 9'));

// lightcase
$document->addStyleSheet("{$template}/assets/lightcase/css/lightcase.css");
$document->addScript("{$template}/assets/lightcase/js/lightcase.js");

$document->addScript("{$template}/js/script.js");

// $is_home_page = $menu->getActive() == $menu->getDefault($language->getTag());

$this->setHtml5(true);
?>
<!doctype html>
<html>
 <head>
  <script src="/templates/nbmgtu/assets/jquery/js/jquery.min.js"></script>
  <jdoc:include type="head"/>
  <meta http-equiv="X-UA-Compatible" content="IE=Edge">
 </head>
 <body>

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

  <table class="header" cellspacing="0" cellpadding="6px">
   <tr>
    <td class="left"><header>NBMGTU</header></td>
    <td class="right">
     <jdoc:include type="modules" name="fadeimages"/>
    </td>
   </tr>
  </table>

  <table class="main">
   <tr>
    <td class="left">
     <jdoc:include type="modules" name="left" style="moduletable"/>
    </td>

    <td class="content">
     <jdoc:include type="message"/>

     <?php if ($this->params->get('show_page_heading', FALSE)) : ?>
      <h1><?php echo $this->params->get('page_heading') ? $this->params->get('page_heading') : JFactory::getApplication()->getMenu()->getActive()->title; ?></h1>
     <?php endif; ?>

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