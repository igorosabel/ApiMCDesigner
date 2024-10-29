<?php foreach ($list as $i => $design): ?>
	{
		"id": <?php echo $design->id ?>,
		"name": "<?php echo urlencode($design->name) ?>",
		"slug": "<?php echo $design->slug ?>",
		"sizeX": <?php echo $design->size_x ?>,
		"sizeY": <?php echo $design->size_y ?>
	}<?php if ($i < count($list) - 1): ?>,<?php endif ?>
<?php endforeach ?>
