<?
$cs=Yii::app()->clientScript;
$cs->registerScriptFile('/js/jquery.synctranslit.js', CClientScript::POS_HEAD);
$cs->registerScript('translit', "
    $('#productTitle').syncTranslit({destination: 'slug'});

", CClientScript::POS_READY);
?>
<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'catalog-brands-form',
	'htmlOptions'=>array('enctype' => 'multipart/form-data'),
	'enableAjaxValidation'=>false,
)); ?>

	<p class="note">Поля, отмеченные звездочкой <span class="required">*</span>, обязательны для заполнения.</p>

	<?php echo $form->errorSummary($model); ?>

	<div class="row">
		<?php echo $form->labelEx($model,'name'); ?>
		<?php echo $form->textField($model,'name',array('size'=>60,'maxlength'=>255, 'id'=>'productTitle')); ?>
		<?php echo $form->error($model,'name'); ?>
	</div>
	
	<div class="row">
		<?php echo $form->labelEx($model,'link'); ?>
		<?php echo $form->textField($model,'link',array('size'=>60,'maxlength'=>255, 'id'=>'slug')); ?>
		<?php echo $form->error($model,'link'); ?>
	</div>	
	
	
	<div class="row">
		<?php echo $form->labelEx($model,'image'); ?>
        <?php
            if ($model->image)
            echo CHtml::image('/upload/catalog/brand/'.$model->image);
        ?>
		<?php echo $form->fileField($model,'image'); ?>
		<?php echo $form->error($model,'image'); ?>
	</div>
	<!--div class="row">
		<?/*php echo $form->labelEx($model,'country'); ?>
		<?php echo $form->textField($model,'country',array('size'=>60,'maxlength'=>255)); ?>
		<?php echo $form->error($model,'country'); */?>
	</div-->
	
	
	
	<div class="row">
		<?php echo $form->labelEx($model,'text'); ?>
		<?php $this->widget('application.extensions.ckeditor.CKEditor', array(
				'model'=>$model,
				'attribute'=>'text',
				'language'=>'ru',
				'editorTemplate'=>'full',
		)); ?>
		<?php echo $form->error($model,'text'); ?>
	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton($model->isNewRecord ? 'Добавить' : 'Сохранить'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->