<?php
Yii::app()->clientScript
	->registerScriptFile('/js/admin/jquery.synctranslit.js', CClientScript::POS_HEAD)
    ->registerScript('translit', "
        $('#block-title').syncTranslit({destination: 'block-name'});
    ", CClientScript::POS_READY);
?>
<div class="form">
	<?php $form = $this->beginWidget('CActiveForm', array(
		'id' => 'block-form',
	)); ?>

	<p class="note">Поля, помеченные звездочкой <span class="required">*</span> обязательны для заполнения.</p>

	<?php echo $form->errorSummary($model); ?>

	<div class="row">
		<?php echo $form->labelEx($model, 'title'); ?>
		<?php echo $form->textField($model, 'title',array('id' => 'block-title', 'size' => 60, 'maxlength' => 255)); ?>
		<?php echo $form->error($model, 'title'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model, 'name'); ?>
		<?php echo $form->textField($model, 'name', array('id' => 'block-name', 'size' => 60, 'maxlength' => 255));?>
		<?php echo $form->error($model, 'name'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model, 'area_id'); ?>
		<?php echo $form->dropDownList($model, 'area_id', Area::getListed()); ?>
		<?php echo $form->error($model, 'area_id'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model, 'visible'); ?>
		<?php echo $form->checkBox($model, 'visible'); ?>
		<?php echo $form->error($model, 'visible'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model, 'view'); ?>
		<?php echo $form->dropDownList($model, 'view', $model->getViews()); ?>
		<?php echo $form->error($model, 'view'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model, 'css_class'); ?>
		<?php echo $form->textField($model, 'css_class', array('size' => 60, 'maxlength' => 255));?>
		<?php echo $form->error($model, 'css_class'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model, 'content'); ?>
        <?php $this->widget('ext.ckeditor.CKEditor', array('model' => $model, 'attribute' => 'content', 'language' => 'ru', 'editorTemplate' => 'full')); ?>
		<?php echo $form->error($model, 'content'); ?>
	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton($model->isNewRecord ? 'Создать' : 'Сохранить'); ?>
	</div>

<?php $this->endWidget(); ?>

</div>