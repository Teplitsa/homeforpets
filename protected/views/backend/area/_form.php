<?php
Yii::app()->clientScript
    ->registerScriptFile('/js/admin/jquery.synctranslit.js', CClientScript::POS_HEAD)
    ->registerScript('translit', "
        $('#area-title').syncTranslit({destination: 'area-name'});
	", CClientScript::POS_READY);
?>
<div class="form">

<?php $form = $this->beginWidget('CActiveForm', array(
	'id' => 'area-form',
)); ?>

	<p class="note">Поля, отмеченные звездочкой <span class="required">*</span> обязательны для заполнения!</p>

	<?php echo $form->errorSummary($model); ?>

    <div class="row">
		<?php echo $form->labelEx($model, 'title'); ?>
		<?php echo $form->textField($model, 'title', array('id' => 'area-title', 'size' => 60, 'maxlength' => 255)); ?>
		<?php echo $form->error($model, 'title'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model, 'name'); ?>
		<?php echo $form->textField($model, 'name', array('id' => 'area-name', 'size' => 60, 'maxlength' => 255)); ?>
		<?php echo $form->error($model, 'name'); ?>
	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton($model->isNewRecord ? 'Создать' : 'Сохранить'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->