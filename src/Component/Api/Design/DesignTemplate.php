<?php if (is_null($design)): ?>
null
<?php else: ?>
{
	"id": <?php echo $design->id ?>,
	"name": "<?php echo urlencode($design->name) ?>",
	"slug": "<?php echo $design->slug ?>",
	"sizeX": <?php echo $design->size_x ?>,
	"sizeY": <?php echo $design->size_y ?>,
	"levels": [
<?php foreach ($design->getLevels() as $i => $level): ?>
		{
			"id": <?php echo $level->id ?>,
			"name": "<?php echo urlencode($level->name) ?>",
			"height": <?php echo $level->height ?>,
			"data": <?php echo $level->data ?>
		}<?php if ($i < count($design->getLevels()) - 1): ?>,<?php endif ?>
<?php endforeach ?>
	]
}
<?php endif ?>
