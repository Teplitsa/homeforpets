<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'catalog-complectation-values-form',
	'enableAjaxValidation'=>false,
)); ?>

	<p class="note">Поля, отмеченные звездочкой <span class="required">*</span>, обязательны для заполнения.</p>

	<?php echo $form->errorSummary($model); ?>

	<div class="row">
		<?php echo $form->labelEx($model,'value'); ?>
		<?php echo $form->textField($model,'value',array('size'=>60,'maxlength'=>255)); ?>
		<?php echo $form->error($model,'value'); ?>
	</div>
	
	<div class="row">
		<?php echo $form->labelEx($model,'article'); ?>
		<?php echo $form->textField($model,'article',array('size'=>60,'maxlength'=>255)); ?>
		<?php echo $form->error($model,'article'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'correction_type'); ?>
		<?php echo $form->dropDownList($model,'correction_type', $model->correctionTypes); ?>
		<?php echo $form->error($model,'correction_type'); ?>
	</div>
    
	<div class="row">
		<?php echo $form->labelEx($model,'price_correction'); ?>
		<?php echo $form->textField($model,'price_correction'); ?>
		<?php echo $form->error($model,'price_correction'); ?>
	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton($model->isNewRecord ? 'Создать' : 'Сохранить'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->