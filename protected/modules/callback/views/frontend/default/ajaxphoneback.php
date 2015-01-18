<a href="#" class="form-close"></a>
<?php if (Yii::app()->user->hasFlash('callback_message')): ?>
<div class="flash-success">
    <?php echo Yii::app()->user->getFlash('callback_message'); ?>
</div>
<?php else: ?>
<div class="pb-form">
	<?php $form = $this->beginWidget('CActiveForm', array(
		'id' => 'phoneback-form',
		'action' => '/callback/default/phoneback'
	)); ?>
	
	<div class="row wp">
		Введите ваши контактные данные и мы перезвоним
	</div>
	
	<div class="row wp">
		<?php echo $form->label($model, 'name'); ?>
		<?php echo $form->textField($model, 'name', array('maxlength' => 256)); ?>
	</div>
	
	<div class="row wp">
		<?php echo $form->label($model, 'phone'); ?>
		<?php echo $form->textField($model, 'phone', array('maxlength' => 256)); ?>
	</div>
	
	<div class="row buttons">
		<?php echo CHtml::submitButton('Заказать бесплатный звонок', array('class' => 's-btn')); ?>
	</div>
	
	<?php $this->endWidget(); ?>
</div>
<?php endif; ?>