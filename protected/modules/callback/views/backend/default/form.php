<?php
/* @var $this DefaultController */
/* @var $model CallbackConfig */
/* @var $form CActiveForm */

Yii::app()->clientScript->registerScript('callback-config', "

	$(document).on('click', '#CallbackConfig_enabled', function(){
		$('#callback-config-form-form input[type=text], #callback-config-form-form select').prop('disabled', !$(this).prop('checked'));
	});

	$(document).on('change', '#CallbackConfig_type', function(){
		if ($(this).val() == 'smtp')
			$('#callback-config-form-form .smtp-block').show();
		else
			$('#callback-config-form-form .smtp-block').hide();
	});

", CClientScript::POS_READY);
$this->breadcrumbs = array(
	'Настройки обратной связи',
);
$disabled = ($model->enabled ? '' : 'disabled');
?>
<h1>Настройки обратной связи</h1>
<?php if (Yii::app()->user->hasFlash('success')):?>
	<div class="flash-success">
		<?php  echo Yii::app()->user->getFlash('success');?>
	</div>
<?php else: ?>
	<div class="form">

	<?php $form = $this->beginWidget('CActiveForm', array(
		'id' => 'callback-config-form-form',
	)); ?>

		<p class="note">Поля, отмеченные <span class="required">*</span>, обязательны для заполнения</p>

		<?php echo $form->errorSummary($model); ?>

		<div class="row">
			<?php echo $form->label($model, 'enabled'); ?>
			<?php echo $form->checkBox($model, 'enabled'); ?>
			<?php echo $form->error($model, 'enabled'); ?>
		</div>

		<div class="row">
			<?php echo $form->labelEx($model, 'type'); ?>
			<?php echo $form->dropDownList($model, 'type', $model->getTransportTypes(), array('disabled' => $disabled)); ?>
			<?php echo $form->error($model, 'type'); ?>
		</div>

		<div class="smtp-block" style="display: <?php echo ($model->type == 'smtp' ? 'block' : 'none'); ?>">
			<div class="row">
				<?php echo $form->labelEx($model, 'host'); ?>
				<?php echo $form->textField($model, 'host', array('disabled' => $disabled)); ?>
				<?php echo $form->error($model, 'host'); ?>
			</div>

			<div class="row">
				<?php echo $form->labelEx($model, 'username'); ?>
				<?php echo $form->textField($model, 'username', array('disabled' => $disabled)); ?>
				<?php echo $form->error($model, 'username'); ?>
			</div>

			<div class="row">
				<?php echo $form->labelEx($model, 'password'); ?>
				<?php echo $form->textField($model, 'password', array('disabled' => $disabled)); ?>
				<?php echo $form->error($model, 'password'); ?>
			</div>

			<div class="row">
				<?php echo $form->labelEx($model, 'port'); ?>
				<?php echo $form->textField($model, 'port', array('disabled' => $disabled)); ?>
				<?php echo $form->error($model, 'port'); ?>
			</div>

			<div class="row">
				<?php echo $form->labelEx($model, 'encryption'); ?>
				<?php echo $form->dropDownList($model, 'encryption', $model->getEncryptions(), array('empty' => 'Не указано	', 'disabled' => $disabled)); ?>
				<?php echo $form->error($model, 'encryption'); ?>
			</div>
		</div>

		<div class="row">
			<?php echo $form->labelEx($model, 'sender'); ?>
			<?php echo $form->textField($model, 'sender', array('disabled' => $disabled)); ?>
			<?php echo $form->error($model, 'sender'); ?>
		</div>

		<div class="row buttons">
			<?php echo CHtml::submitButton('Сохранить'); ?>
		</div>

	<?php $this->endWidget(); ?>

	</div>
<?php endif; ?>