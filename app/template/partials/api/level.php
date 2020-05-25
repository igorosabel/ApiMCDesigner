<?php if (is_null($values['level'])): ?>
	null
<?php else: ?>
	{
		"id": <?php echo $values['level']->get('id') ?>,
		"name": "<?php echo urlencode($values['level']->get('name')) ?>",
		"height": <?php echo $values['level']->get('height') ?>,
		"data": <?php echo $values['level']->get('data') ?>
	}
<?php endif ?>