<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'catalog-pricetypes-form',
	'enableAjaxValidation'=>false,
)); ?>

	<p class="note"><span class="required">*</span> - обязательные поля.</p>

	<?php echo $form->errorSummary($model); ?>

	<div class="row">
		<?php echo $form->labelEx($model,'name'); ?>
		<?php echo $form->textField($model,'name',array('size'=>60,'maxlength'=>255)); ?>
		<?php echo $form->error($model,'name'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'ident_field'); ?>
		<?php echo $form->textField($model,'ident_field'); ?>
		<?php echo $form->error($model,'ident_field'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'price_field'); ?>
		<?php echo $form->textField($model,'price_field'); ?>
		<?php echo $form->error($model,'price_field'); ?>
	</div>
	
	<div class="row">
		<?php echo $form->labelEx($model,'brand_id'); ?>
		<?php echo $form->dropDownList($model,'brand_id', CatalogPricetypes::getBrandlist(), array('empty'=>'Выберите бренд товара')); ?>
        <?php echo $form->error($model,'brand_id'); ?>
	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton($model->isNewRecord ? 'Создать' : 'Сохранить'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->