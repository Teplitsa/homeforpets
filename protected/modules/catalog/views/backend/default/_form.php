<?
$cs=Yii::app()->clientScript;
$cs->registerScriptFile('/js/admin/jquery.synctranslit.js', CClientScript::POS_HEAD);
$cs->registerScript('translit', "
    $('#productTitle').syncTranslit({destination: 'slug'});

", CClientScript::POS_READY);
?>
<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'catalog-category-form',
	'htmlOptions'=>array('enctype' => 'multipart/form-data'),
	'enableAjaxValidation'=>false,
)); ?>

	<p class="note">Поля, отмеченные <span class="required">*</span>, обязательны для заполнения.</p>

	<?php echo $form->errorSummary($model); ?>

	<div class="row">
		<?/*php echo $form->labelEx($model,'parent_id'); ?>
		<?php echo $form->dropDownList($model,'parent_id',CatalogCategory::getListed()); ?>
		<?php echo $form->error($model,'parent_id');*/?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'title'); ?>
		<?php echo $form->textField($model,'title',array('size'=>60,'maxlength'=>256, 'id'=>'productTitle')); ?>
		<?php echo $form->error($model,'title'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'link'); ?>
		<?php echo $form->textField($model,'link',array('size'=>60,'maxlength'=>256, 'id'=>'slug')); ?>
		<?php echo $form->error($model,'link'); ?>
	</div>
	
	
	<div class="row">
		<?/*php echo $form->labelEx($model,'long_title'); ?>
		<?php echo $form->textField($model,'long_title',array('size'=>60,'maxlength'=>256)); ?>
		<?php echo $form->error($model,'long_title');*/ ?>
	</div>

    <div class="row">
        <?php echo $form->labelEx($model, 'keywords'); ?>
        <?php echo $form->textArea($model, 'keywords', array('cols' => 60, 'rows' => 4)); ?>
        <?php echo $form->error($model, 'keywords'); ?>
    </div>

    <div class="row">
        <?php echo $form->labelEx($model, 'description'); ?>
        <?php echo $form->textArea($model, 'description', array('cols' => 60, 'rows' => 4)); ?>
        <?php echo $form->error($model, 'description'); ?>
    </div>

	<div class="row">
		<?/*php echo $form->labelEx($model,'layout'); ?>
		<?php echo $form->textField($model,'layout',array('size'=>60,'maxlength'=>256)); ?>
		<?php echo $form->error($model,'layout'); */?>
	</div>

	<div class="row">
		<?/*php echo $form->labelEx($model,'product_view'); ?>
		<?php echo $form->radioButtonList($model,'product_view',array('0'=>'Плитка','1'=>'Таблица'),array('style'=>'display:inline;','separator'=>' ')); ?>
		<?php echo $form->error($model,'product_view');*/ ?>
	</div>

	<div class="row">
		<?/*php echo $form->labelEx($model,'image'); ?>
        <?php
            if ($model->image){
                echo CHtml::image('/upload/catalog/category/small/'.$model->image);
                echo "<br/> Заменить изображение: ";
            }
        ?>
		<?php echo $form->fileField($model,'image'); ?>
		<?php echo $form->error($model,'image'); */?>
	</div>

    <?/*php $this->widget('application.extensions.ckeditor.CKEditor', array(
                       'model' => $model,
                       'attribute' => 'text',
                       'language' => 'ru',
                       'editorTemplate' => 'full',
    )); */?>

	<div class="row buttons">
		<?php echo CHtml::submitButton($model->isNewRecord ? 'Добавить' : 'Сохранить'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->