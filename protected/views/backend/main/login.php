
<div class="form">
<h1>Вход в панель администратора</h1>
<?php $form=$this->beginWidget('CActiveForm', array(
	'id' => 'login-form',
	'enableAjaxValidation' => false,
)); ?>

	<p class="note">Поля, отмеченные <span class="required">*</span>, обязательны для заполнения</p>

	<div class="row">
		<?php echo $form->labelEx($model, 'username', array('label' => 'Логин')); ?>
		<?php echo $form->textField($model, 'username'); ?>
		<?php echo $form->error($model, 'username'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model, 'password', array('label' => 'Пароль')); ?>
		<?php echo $form->passwordField($model, 'password'); ?>
		<?php echo $form->error($model, 'password'); ?>
	</div>

	<div class="row rememberMe">
		<?php echo $form->checkBox($model, 'rememberMe'); ?>
		<?php echo $form->label($model, 'rememberMe', array('label' => 'запомнить')); ?>
		<?php echo $form->error($model, 'rememberMe'); ?>
	</div>

	<div class="row submit">
		<?php echo CHtml::submitButton('Войти'); ?>
	</div>

<?php $this->endWidget(); ?>
</div><!-- form -->

<div class="forgotten">
	<span>!</span>
	Если Вы забыли пароль и не можете войти в панель администратора - обратитесь к программистам службы поддержки сайта.
</div>
