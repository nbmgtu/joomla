<?php
defined('_JEXEC') or die;
?>
<div class="fadeimages" id="fadeimages">
 <script language="javascript">
  FADEIMAGES_IMAGES = new Array(<?php echo $fadeimages['list']; ?>);
  FADEIMAGES_STEP = <?php echo $fadeimages['step']; ?>;
  FADEIMAGES_INTERVAL = <?php echo $fadeimages['interval']; ?>;
  FADEIMAGES_SLEEP = <?php echo $fadeimages['sleep']; ?>;
  FADEIMAGES_BASEDIR = "<?php echo $fadeimages['inet']; ?>";
 </script>
 <img src="<?php echo "{$fadeimages['inet']}/{$fadeimages['files'][0]}"; ?>">
 <img src="" style="display:none;">
</div>
