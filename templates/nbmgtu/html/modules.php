<?php
defined('_JEXEC') or die;

function modChrome_moduletable($module, &$params, &$attribs)
{
 if (!empty ($module->content)) : ?>
  <div class="moduletable">
   <?php if ($module->showtitle) : ?>
    <div class="title"><?php echo $module->title; ?></div>
   <?php endif; ?>
   <?php echo $module->content; ?>
  </div>
 <?php endif;
}
