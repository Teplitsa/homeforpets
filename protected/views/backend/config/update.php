<?php
/**
 * @var $this ConfigController 
 * @var $model Config
 */
    $this->breadcrumbs = array(
        'Конфигурация',
    );
?>
<h1>Редактирование конфигурации сайта</h1>  
<?php if (Yii::app()->user->hasFlash('success')):?>
    <div class="flash-success">
        <?php  echo Yii::app()->user->getFlash('success');?>
    </div>
<?php else: ?>
	<div class="form">
	<?php $form = $this->beginWidget('CActiveForm', array(
		'id' => 'siteconfig-form',
		'enableAjaxValidation' => false,
	)); ?>
		<p class="note">Поля, отмеченные <span class="required">*</span>, обязательны для заполнения</p>
		<?php echo $form->errorSummary($model); ?>
		<div class="row">
			<?php echo $form->labelEx($model, 'sitename'); ?>
			<?php echo $form->textField($model, 'sitename'); ?>
		</div>
		<div class="row">
			<?php echo $form->labelEx($model, 'mainpage_id'); ?>
			<?php echo $form->dropDownList($model, 'mainpage_id', Page::getListed()); ?>
		</div>
		<div class="row">
			<?php echo $form->labelEx($model, 'author'); ?>
			<?php echo $form->textField($model, 'author'); ?>
		</div>
		<div class="row">
			<?php echo $form->labelEx($model, 'adminonly'); ?>
			<?php echo $form->checkBox($model, 'adminonly'); ?>
		</div>
		<div class="row submit">
			<?php echo CHtml::submitButton('Сохранить'); ?>
		</div>
	<?php $this->endWidget(); ?>
	</div>
<?php endif; ?>