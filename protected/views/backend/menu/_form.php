<?php 
Yii::app()->clientScript
	->registerScriptFile('/js/admin/jquery.synctranslit.js', CClientScript::POS_HEAD)
    ->registerScript('translit', "
        $('#menu-title').syncTranslit({destination: 'menu-name'});
    ", CClientScript::POS_READY);
?>
<div class="form">
<?php $form = $this->beginWidget('CActiveForm', array(
	'id' => 'menu-form',
)); ?>
	<p class="note">Поля, отмеченные <span class="required">*</span>, обязательны для заполнения</p>

	<?php echo $form->errorSummary($model); ?>

	<div class="row">
		<?php echo $form->labelEx($model, 'title'); ?>
		<?php echo $form->textField($model, 'title', array('size' => 60, 'maxlength' => 255, 'id' => 'menu-title')); ?>
		<?php echo $form->error($model, 'title'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model, 'name'); ?>
		<?php echo $form->textField($model, 'name', array('size' => 60, 'maxlength' => 255, 'id' => 'menu-name')); ?>
		<?php echo $form->error($model, 'name'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model, 'items_template'); ?>
		<?php echo $form->textField($model, 'items_template', array('size' => 60, 'maxlength' => 255)); ?>
		<?php echo $form->error($model, 'items_template'); ?>
        <p class="hint">Например: <?echo CHtml::encode('<div class="item-layout">{menu}</div>, где {menu} - пункт меню');?></p>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model, 'activeitem_class'); ?>
		<?php echo $form->textField($model, 'activeitem_class', array('size' => 60, 'maxlength' => 255)); ?>
		<?php echo $form->error($model, 'activeitem_class'); ?>
        <p class="hint">По умолчанию - active</p>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model, 'firstitem_class'); ?>
		<?php echo $form->textField($model, 'firstitem_class', array('size' => 60, 'maxlength' => 255)); ?>
		<?php echo $form->error($model, 'firstitem_class'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model, 'lastitem_class'); ?>
		<?php echo $form->textField($model, 'lastitem_class', array('size' => 60, 'maxlength' => 255)); ?>
		<?php echo $form->error($model, 'lastitem_class'); ?>
	</div>
    
	<div class="row buttons">
		<?php echo CHtml::submitButton($model->isNewRecord ? 'Добавить' : 'Сохранить'); ?>
	</div>

<?php $this->endWidget(); ?>
</div>