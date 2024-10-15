<?php if (is_null($design)): ?>
null
<?php else: ?>
{
	"id": <?php echo $design->get('id') ?>,
	"name": "<?php echo urlencode($design->get('name')) ?>",
	"slug": "<?php echo $design->get('slug') ?>",
	"sizeX": <?php echo $design->get('size_x') ?>,
	"sizeY": <?php echo $design->get('size_y') ?>,
	"levels": [
<?php foreach ($design->getLevels() as $i => $level): ?>
		{
			"id": <?php echo $level->get('id') ?>,
			"name": "<?php echo urlencode($level->get('name')) ?>",
			"height": <?php echo $level->get('height') ?>,
			"data": <?php echo $level->get('data') ?>
		}<?php if ($i < count($design->getLevels()) - 1): ?>,<?php endif ?>
<?php endforeach ?>
	]
}
<?php endif ?>
