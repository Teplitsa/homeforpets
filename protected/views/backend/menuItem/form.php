<h1><?php echo ($model->isNewRecord ? 'Добавление' : 'Редактирование'); ?> пункта меню</h1>
<div class="form">
<?php $form = $this->beginWidget('CActiveForm', array(
	'id' => 'menu-item-form',
)); ?>

	<p class="note">Поля, отмеченные <span class="required">*</span>, обязательны для заполнения</p>

	<?php echo $form->errorSummary($model); ?>

	<div class="row">
		<?php echo $form->labelEx($model, 'menu_id'); ?>
		<?php echo $form->dropDownList($model, 'menu_id', Menu::getListed(), array('empty' => '---')); ?>
		<?php echo $form->error($model, 'menu_id'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model, 'parent_id'); ?>
		<?php echo $form->dropDownList($model, 'parent_id', MenuItem::getListed(), array('empty' => '---')); ?>
		<?php echo $form->error($model, 'parent_id'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model, 'title'); ?>
		<?php echo $form->textField($model, 'title', array('size' => 60, 'maxlength' => 128)); ?>
		<?php echo $form->error($model, 'title'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model, 'link'); ?>
		<?php echo $form->textField($model, 'link', array('size' => 60, 'maxlength' => 128)); ?>
		<?php echo $form->error($model, 'link'); ?>
	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton($model->isNewRecord ? 'Добавить' : 'Сохранить'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->