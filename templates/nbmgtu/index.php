<?php
defined('_JEXEC') or die;

$app = JFactory::getApplication();
$doc = JFactory::getDocument();
$menu = $app->getMenu();
$lang = JFactory::getLanguage();

$template_url = $this->baseurl . '/templates/' . $this->template;
$doc->addStyleSheet($template_url . '/css/template.css');
$doc->addStyleSheet('http://fonts.googleapis.com/css?family=Oswald:400,300');

$is_home_page = $menu->getActive() == $menu->getDefault($lang->getTag());

$this->setHtml5(true);
?>
<!doctype html>
<html>
 <head>
  <jdoc:include type="head"/>
  <meta http-equiv="X-UA-Compatible" content="IE=Edge">
  <!--[if lt IE 9]>
   <script src="http://html5shiv.googlecode.com/svn/trunk/html5.js"></script>
  <![endif]-->
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
     <?php endif;?>

     <jdoc:include type="component"/>
    </td>

    <td class="right">
     <jdoc:include type="modules" name="right" style="moduletable"/>
    </td>
   </tr>
  </table>

  <footer>
  </footer>
 </body>
</html>