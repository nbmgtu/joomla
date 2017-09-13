<?php
defined('_JEXEC') or die('Restricted access');
?>
<div class="journal">
<h2><?php echo $this->data['title']; ?></h2>
<p class="caption"><b><?php echo JText::_('COM_JOURNAL_ISSUES'); ?></b></p>
<p><?php echo JText::_('COM_JOURNAL_ISSUES_DESCRIPTION'); ?></p>

<table border=0 class="issues">
<tr><th>#<th><?php echo JText::_('COM_JOURNAL_ISSUES_ISSUES'); ?><th><?php echo JText::_('COM_JOURNAL_ISSUES_HITS'); ?>
<?php
 foreach ( $this->data['issues'] as $id => $issue )
  echo "<tr><td>{$id}<td><a href=\"{$issue['link']}\">{$issue['title']}</a><td align=right>{$issue['hits']}";
?>
</table>
</div>
