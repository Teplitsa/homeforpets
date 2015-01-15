<?php
$this->breadcrumbs=array(
	'Настройки каталога',
);
?>

<h1>Настройки каталога</h1>

    <?php if(Yii::app()->user->hasFlash('success')):?>
    <div class="flash-success">
        <?php  echo Yii::app()->user->getFlash('success');?>
    </div>


<?php else: ?>

<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'catalogconfig-form',
    'htmlOptions'=>array('enctype' => 'multipart/form-data'),
	'enableAjaxValidation'=>true,
)); ?>
    <p class="note">Поля, отмеченные <span class="required">*</span>, обязательны для заполнения</p>
	<?php echo $form->errorSummary(array($model)); ?>
	<div class="row">
		<?php echo $form->labelEx($model,'title'); ?>
		<?php echo $form->textField($model,'title'); ?>
        <?php echo $form->error($model, 'title'); ?>
	</div>
	<div class="row">
		<?php echo $form->labelEx($model,'keywords'); ?>
        <?php echo $form->textArea($model, 'keywords', array('cols' => 60, 'rows' => 4)); ?>
        <?php echo $form->error($model, 'keywords'); ?>
	</div>
	<div class="row">
		<?php echo $form->labelEx($model,'description'); ?>
        <?php echo $form->textArea($model, 'description', array('cols' => 60, 'rows' => 4)); ?>
        <?php echo $form->error($model, 'description'); ?>
	</div>
	<div class="row">
		<?php echo $form->labelEx($model,'layout'); ?>
		<?php echo $form->textField($model,'layout'); ?>
        <?php echo $form->error($model, 'layout'); ?>
	</div>
	<div class="row">
		<?php echo $form->labelEx($model,'cat_perpage'); ?>
		<?php echo $form->textField($model,'cat_perpage'); ?>
        <?php echo $form->error($model, 'cat_perpage'); ?>
	</div>
	<div class="row">
		<?php echo $form->labelEx($model,'product_perpage'); ?>
		<?php echo $form->textField($model,'product_perpage'); ?>
        <?php echo $form->error($model, 'product_perpage'); ?>
	</div>
    <h3>Размеры изображений категорий</h3>
	<div class="row">
		<?php echo $form->labelEx($model,'c_image_small_w'); ?>
		<?php echo $form->textField($model,'c_image_small_w'); ?>
        <?php echo $form->error($model, 'c_image_small_w'); ?>
	</div>
	<div class="row">
		<?php echo $form->labelEx($model,'c_image_small_h'); ?>
		<?php echo $form->textField($model,'c_image_small_h'); ?>
        <?php echo $form->error($model, 'c_image_small_h'); ?>
	</div>
    <h3>Размеры изображений товаров</h3>
	<div class="row">
		<?php echo $form->labelEx($model,'p_image_middle_w'); ?>
		<?php echo $form->textField($model,'p_image_middle_w'); ?>
        <?php echo $form->error($model, 'p_image_middle_w'); ?>
	</div>
	<div class="row">
		<?php echo $form->labelEx($model,'p_image_middle_h'); ?>
		<?php echo $form->textField($model,'p_image_middle_h'); ?>
        <?php echo $form->error($model, 'p_image_middle_h'); ?>
	</div>
	<div class="row">
		<?php echo $form->labelEx($model,'p_image_small_w'); ?>
		<?php echo $form->textField($model,'p_image_small_w'); ?>
        <?php echo $form->error($model, 'p_image_small_w'); ?>
	</div>
	<div class="row">
		<?php echo $form->labelEx($model,'p_image_small_h'); ?>
		<?php echo $form->textField($model,'p_image_small_h'); ?>
        <?php echo $form->error($model, 'p_image_small_h'); ?>
	</div>
    <h3>Водяной знак на изображениях товаров</h3>
    <div class="row">
		<?php echo $form->labelEx($model,'watermark_image'); ?>
        <?php
            if ($model->watermark_image)
            echo CHtml::image('/upload/catalog/product/watermark/'.$model->watermark_image, 'watermark', array('class'=>'watermark_img'));
        ?>
		<?php echo $form->fileField($model,'watermark_image'); ?>
		<?php echo $form->error($model,'watermark_image'); ?>
        <p class="tint">Файл .png</p>
    </div>
	<div class="row">
		<?php echo $form->labelEx($model,'watermark_x'); ?>
		<?php echo $form->textField($model,'watermark_x'); ?>
        <?php echo $form->error($model, 'watermark_x'); ?>
        <p class="tint">От правого нижнего угла картинки</p>
	</div>
	<div class="row">
		<?php echo $form->labelEx($model,'watermark_y'); ?>
		<?php echo $form->textField($model,'watermark_y'); ?>
        <?php echo $form->error($model, 'watermark_y'); ?>
        <p class="tint">От правого нижнего угла картинки</p>
	</div>
    <div class="row">
		<?php echo $form->labelEx($model,'no_watermark'); ?>
		<?php echo $form->checkBox($model,'no_watermark'); ?>
        <?php echo $form->error($model, 'no_watermark'); ?>
    </div>
    <div class="row">
        <?php echo $form->labelEx($model, 'text'); ?>
        <?php $this->widget('application.extensions.ckeditor.CKEditor', array(
                                                                             'model' => $model,
                                                                             'attribute' => 'text',
                                                                             'language' => 'ru',
                                                                             'editorTemplate' => 'full',
                                                                        )); ?>
        <?php echo $form->error($model, 'text'); ?>
    </div>


    <div class="row submit">
		<?php echo CHtml::submitButton('Сохранить'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->

<?php endif; ?>
