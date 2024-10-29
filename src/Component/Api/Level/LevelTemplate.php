<?php if (is_null($level)): ?>
	null
<?php else: ?>
	{
		"id": <?php echo $level->id ?>,
		"name": "<?php echo urlencode($level->name) ?>",
		"height": <?php echo $level->height ?>,
		"data": <?php echo $level->data ?>
	}
<?php endif ?>
