<?php if (is_null($values['Level'])): ?>
	null
<?php else: ?>
	{
		"id": <?php echo $values['Level']->get('id') ?>,
		"name": "<?php echo urlencode($values['Level']->get('name')) ?>",
		"height": <?php echo $values['Level']->get('height') ?>,
		"data": <?php echo $values['Level']->get('data') ?>
	}
<?php endif ?>
