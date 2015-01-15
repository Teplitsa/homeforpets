<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'catalog-priceprofile-form',
	'enableAjaxValidation'=>false,
)); ?>

	<p class="note">Поля, отмеченные звездочкой <span class="required">*</span>, обязательны для заполнения.</p>

	<?php echo $form->errorSummary($model); ?>

	<div class="row">
		<?php echo $form->labelEx($model,'name'); ?>
		<?php echo $form->textField($model,'name',array('size'=>60,'maxlength'=>255)); ?>
		<?php echo $form->error($model,'name'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'factor'); ?>
		<?php echo $form->textField($model,'factor'); ?>
		<?php echo $form->error($model,'factor'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'corrector'); ?>
		<?php echo $form->textField($model,'corrector'); ?>
		<?php echo $form->error($model,'corrector'); ?>
	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton($model->isNewRecord ? 'Добавить' : 'Сохранить'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->