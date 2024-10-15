<?php foreach ($list as $i => $design): ?>
	{
		"id": <?php echo $design->get('id') ?>,
		"name": "<?php echo urlencode($design->get('name')) ?>",
		"slug": "<?php echo $design->get('slug') ?>",
		"sizeX": <?php echo $design->get('size_x') ?>,
		"sizeY": <?php echo $design->get('size_y') ?>
	}<?php if ($i < count($list) - 1): ?>,<?php endif ?>
<?php endforeach ?>
