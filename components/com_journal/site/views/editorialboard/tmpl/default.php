<?php
defined('_JEXEC') or die('Restricted access');
?>
<div class="journal">
<h2><?php echo $this->data['title']; ?></h2>
<p class="caption"><b><?php echo JText::_('COM_JOURNAL_EDITORBOARD'); ?></b></p>
<?php echo $this->ShowLangPage($this->data['content']); ?>
</div>