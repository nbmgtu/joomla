<?php
defined('_JEXEC') or die('Restricted access');
?>
<h2><?php echo $this->data['title']; ?></h2>
<ul class="menu">
<li><a href="<?php echo $this->data['link']['editorialboard']; ?>" class="category"><?php echo JText::_('COM_JOURNAL_EDITORBOARD'); ?></a></li>
<li><a href="<?php echo $this->data['link']['issues']; ?>" class="category"><?php echo JText::_('COM_JOURNAL_ISSUES'); ?></a></li>
<li><a href="<?php echo $this->data['link']['informationforauthors']; ?>" class="category"><?php echo JText::_('COM_JOURNAL_INFORMATIONFORAUTHORS'); ?></a></li>
</ul>
<br>

<?php echo $this->ShowLangPage($this->data['content'], $this->data['link']['logo']); ?>
