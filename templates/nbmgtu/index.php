<?php
defined('_JEXEC') or die;

$application = JFactory::getApplication();
$document = JFactory::getDocument();
$menu = $application->getMenu();
$language = JFactory::getLanguage();

$template_url = "{$this->baseurl}/templates/{$this->template}";

$document->addStyleSheet("{$template_url}/css/template.css");
$document->addStyleSheet('http://fonts.googleapis.com/css?family=Oswald:400,300');

$document->setMetaData("X-UA-Compatible", "IE=Edge", "http-equiv");
$document->addScript('http://html5shiv.googlecode.com/svn/trunk/html5.js', array('conditional' => 'lt IE 9'));

// jquery
$document->addScript("{$template_url}/assets/jquery/js/jquery.min.js");

// lightcase
$document->addStyleSheet("{$template_url}/assets/lightcase/css/lightcase.css");
$document->addScript("{$template_url}/assets/lightcase/js/lightcase.js");
$document->addScriptDeclaration("
 jQuery(document).ready(function($) {
  $('a[data-rel^=lightcase]').lightcase();
 });
");

// options
/*
$document->addScriptOptions('mod_example',
 array(
  'colors' => array('selector' => 'body', 'color' => 'orange'),
  'sliderOptions' => array('selector' => '.my-slider', 'timeout' => 300, 'fx' => 'fade')
 )
);
<script>
var myOptions = Joomla.getOptions('mod_example');
console.log(myOptions.colors); // Print in the browser console your options
console.log(myOptions.sliderOptions);
</script>
*/

$is_home_page = $menu->getActive() == $menu->getDefault($language->getTag());

$this->setHtml5(true);
?>
<!doctype html>
<html>
 <head>
  <jdoc:include type="head"/>
  <meta http-equiv="X-UA-Compatible" content="IE=Edge">
 </head>
 <body>

  <div class="navigation">
   <jdoc:include type="modules" name="mainmenu"/>
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

     <?php if ( !$is_home_page ): ?>
     <div class="caption">
      <h1><?php echo $this->getTitle(); ?></h1>
     </div>
     <?php endif; ?>

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