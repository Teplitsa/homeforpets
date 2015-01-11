<?php $this->beginContent('//layouts/main_layout'); ?>
<div class="inner">
	<div class="breadcrumbs">
	<?php $this->widget('zii.widgets.CBreadcrumbs', array(
		'homeLink' => CHtml::link('Главная','/'),
		'separator' => ' <span> / </span> ',
		'links' => $this->breadcrumbs,
		));
	?>
	</div>
	<?php echo $content; ?>
	<div class="clear"></div>
</div>
<?php $this->endContent(); ?>