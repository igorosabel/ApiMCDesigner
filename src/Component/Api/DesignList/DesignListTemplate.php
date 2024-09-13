<?php foreach ($values['list'] as $i => $des): ?>
	{
		"id": <?php echo $des->get('id') ?>,
		"name": "<?php echo urlencode($des->get('name')) ?>",
		"slug": "<?php echo $des->get('slug') ?>",
		"sizeX": <?php echo $des->get('size_x') ?>,
		"sizeY": <?php echo $des->get('size_y') ?>
	}<?php if ($i<count($values['list'])-1): ?>,<?php endif ?>
<?php endforeach ?>
