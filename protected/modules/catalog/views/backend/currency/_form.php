<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'catalog-currency-form',
	'enableAjaxValidation'=>false,
)); ?>

	<p class="note">Fields with <span class="required">*</span> are required.</p>

	<?php echo $form->errorSummary($model); ?>

	<div class="row">
		<?php echo $form->labelEx($model,'title'); ?>
		<?php echo $form->textField($model,'title',array('size'=>60,'maxlength'=>255)); ?>
		<?php echo $form->error($model,'title'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'code'); ?>
		<?php echo $form->textField($model,'code',array('size'=>10,'maxlength'=>10)); ?>
		<?php echo $form->error($model,'code'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'cursetorub'); ?>
		<?php echo $form->textField($model,'cursetorub'); ?>
		<?php echo $form->error($model,'cursetorub'); ?>
	</div>
    
	<div class="row">
		<?php echo $form->labelEx($model,'curseauto'); ?>
		<?php echo $form->checkBox($model,'curseauto'); ?>
		<?php echo $form->error($model,'curseauto'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'prefix'); ?>
		<?php echo $form->textField($model,'prefix',array('size'=>10,'maxlength'=>10)); ?>
		<?php echo $form->error($model,'prefix'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'beforeprefix'); ?>
		<?php echo $form->checkBox($model,'beforeprefix'); ?>
		<?php echo $form->error($model,'beforeprefix'); ?>
	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton($model->isNewRecord ? 'Создать' : 'Сохранить'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->