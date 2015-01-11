<?php 
/**
 * @var $this UserController 
 * @var $model User
 */
$this->breadcrumbs = array(
	'Смена пароля'
);
?>
<h1>Смена пароля</h1>
<?php if (Yii::app()->user->hasFlash('success')):?>
	<div class="flash-success">
		<?php  echo Yii::app()->user->getFlash('success');?>
    </div>
<?php else: ?>
	<div class="form">
	<?php $form = $this->beginWidget('CActiveForm', array(
		'id' => 'changepassword-form',
		'enableAjaxValidation' => false,
	));	?>
		<p class="note">Поля, отмеченные <span class="required">*</span>, обязательны для заполнения</p>
		<?php echo $form->errorSummary($model); ?>
		<div class="row">
			<?php echo $form->labelEx($model, 'newPassword'); ?>
			<?php echo $form->passwordField($model, 'newPassword', array('size' => 60, 'maxlength' => 128)); ?>
		</div>
		<div class="row">
			<?php echo $form->labelEx($model, 'confirmNewPassword'); ?>
			<?php echo $form->passwordField($model, 'confirmNewPassword', array('size' => 60, 'maxlength' => 128)); ?>
		</div>
		<div class="row submit">
			<?php echo CHtml::submitButton('Сохранить'); ?>
		</div>
	<?php $this->endWidget(); ?>
	</div>
<?php endif; ?>