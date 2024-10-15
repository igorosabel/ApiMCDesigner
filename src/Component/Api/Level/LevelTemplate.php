<?php if (is_null($level)): ?>
	null
<?php else: ?>
	{
		"id": <?php echo $level->get('id') ?>,
		"name": "<?php echo urlencode($level->get('name')) ?>",
		"height": <?php echo $level->get('height') ?>,
		"data": <?php echo $level->get('data') ?>
	}
<?php endif ?>
