<?php if (is_null($values['design'])): ?>
null
<?php else: ?>
<?php $des = $values['design']; ?>
{
  "id": <?php echo $des->get('id') ?>,
  "name": "<?php echo urlencode($des->get('name')) ?>",
	"slug": "<?php echo $des->get('slug') ?>",
	"sizeX": <?php echo $des->get('size_x') ?>,
	"sizeY": <?php echo $des->get('size_y') ?>,
  "levels": [
<?php foreach ($des->getLevels() as $i => $level): ?>
    {
      "id": <?php echo $level->get('id') ?>,
      "name": "<?php echo urlencode($level->get('name')) ?>",
      "height": <?php echo $level->get('height') ?>,
      "data": <?php echo $level->get('data') ?>
    }<?php if ($i<count($des->getLevels())-1): ?>,<?php endif ?>
<?php endforeach ?>
  ]
}
<?php endif ?>