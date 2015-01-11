<?php
Yii::app()->clientScript
    ->registerScriptFile('/js/admin/jquery.synctranslit.js', CClientScript::POS_HEAD)
    ->registerScript('translit', "
        $('#page-title').syncTranslit({destination: 'page-link'});
    ", CClientScript::POS_READY);
?>
<h1><?php echo ($model->isNewRecord ? 'Добавление' : 'Редактирование'); ?> страницы</h1>
<div class="form">

    <?php $form = $this->beginWidget('CActiveForm', array('id' => 'page-form')); ?>

    <p class="note">Поля, отмеченные <span class="required">*</span>, обязательны для заполнения.</p>

    <?php echo $form->errorSummary($model); ?>

    <div class="row">
        <?php echo $form->labelEx($model, 'parent_id'); ?>
        <?php echo $form->dropDownList($model, 'parent_id', Page::getListed((int)$model->id), array('empty' => array('0' => 'Не выбрано'))); ?>
        <?php echo $form->error($model, 'parent_id'); ?>
    </div>

    <div class="row">
        <?php echo $form->labelEx($model, 'title'); ?>
        <?php echo $form->textField($model, 'title', array('size' => 60, 'maxlength' => 512, 'id' => 'page-title')); ?>
        <?php echo $form->error($model, 'title'); ?>
    </div>
    
    <div class="row">
        <?php echo $form->labelEx($model, 'link'); ?>
        <?php echo $form->textField($model, 'link', array('size' => 60, 'maxlength' => 128, 'id' => 'page-link')); ?>
        <?php echo $form->error($model, 'link'); ?>
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
		<?php echo $form->labelEx($model, 'layout'); ?>
		<?php echo $form->dropDownList($model, 'layout', $model::$layouts); ?>
		<?php echo $form->error($model, 'layout'); ?>
        <p class="hint">По умолчанию - main. Файлы макетов (.php) находятся в папке protected/views/layouts</p>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model, 'view'); ?>
		<?php echo $form->dropDownList($model, 'view', $model::$views); ?>
		<?php echo $form->error($model, 'view'); ?>
        <p class="hint">По умолчанию - view. Файлы видов (.php) находятся в папке protected/views/pages</p>
	</div>

    <div class="row">
        <?php echo $form->labelEx($model, 'content'); ?>
        <?php $this->widget('ext.ckeditor.CKEditor', array('model' => $model, 'attribute' => 'content', 'language' => 'ru', 'editorTemplate' => 'full')); ?>
        <?php echo $form->error($model, 'content'); ?>
    </div>

    <div class="row buttons">
        <?php echo CHtml::submitButton($model->isNewRecord ? 'Добавить' : 'Сохранить'); ?>
    </div>

    <?php $this->endWidget(); ?>

</div>