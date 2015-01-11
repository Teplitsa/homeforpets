<?php $this->beginContent('//layouts/main'); ?>
	<div class="center">
		<?php $this->widget('zii.widgets.CBreadcrumbs', array(
			'homeLink' => CHtml::link('Главная', '/manage'),
			'links' => $this->breadcrumbs,
		)); ?><!-- breadcrumbs -->

		<?php echo $content; ?>
	</div>
	<div class="left">
	<?php $this->menuWidgets(); ?>
	</div>
<?php $this->endContent(); ?>