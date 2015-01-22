<?php 
/* @var $this ResponseController */
Yii::app()->clientScript->registerScript('group',"

	$(document).on('change', 'select.form-group', function() {
		var group = $(this).val();
		if (!group)
			group = 0;
		$('div.group-block[data-form-group != '+group+']').hide();
		$('div.group-block[data-form-group = '+group+']').show();
	});
 
", CClientScript::POS_READY);
?>
<h1>Предложить животное</h1>
<?php if (Yii::app()->user->hasFlash('callback_message')): ?>
<div class="flash-success">
    <?php echo Yii::app()->user->getFlash('callback_message'); ?>
</div>
<?php else: ?>
<div class="s-form">
<?php $form = $this->beginWidget('CActiveForm', array(
	'id' => 'catalog-response-form',
)); ?>

	<?php echo $form->errorSummary($model); ?>

	<div class="row">
		<div class="column">
			<?php echo $form->labelEx($model, 'name'); ?>:
			<?php echo $form->textField($model, 'name', array('maxlength' => 256)); ?>
		</div>
		<div class="column">
			<?php echo $form->labelEx($model, 'phone'); ?>:
			<?php echo $form->textField($model, 'phone', array('maxlength' => 256)); ?>
		</div>
	</div>

	<div class="row">
		<div class="column">
			<?php echo $form->labelEx($model, 'id_category'); ?>:
			<?php echo $form->dropDownList($model, 'id_category', CHtml::listData(CatalogCategory::model()->findAll('parent_id = 0'), 'id', 'title'), array('empty' => 'Выберите вид животного', 'class' => 'form-group')); ?>
		</div>
		<div class="column">
			<?php echo $form->label($model, 'title'); ?>:
			<?php echo $form->textField($model, 'title', array('maxlength' => 256)); ?>
		</div>
	</div>
	
	<div class="row">
		<div class="column">
			<?php echo $form->label($model, 'age_y'); ?>:
			<div class="inline">
				<?php echo $form->textField($model, 'age_y', array('maxlength' => 256, 'class' => 'sh', 'placeholder' => 'Лет')); ?>
				<?php echo $form->textField($model, 'age_m', array('maxlength' => 256, 'class' => 'sh', 'placeholder' => 'Месяцев')); ?>
				<?php echo $form->textField($model, 'age_w', array('maxlength' => 256, 'class' => 'sh nm', 'placeholder' => 'Недель')); ?>
			</div> 
		</div> 
		<div class="column">
			<?php echo $form->label($model, 'sex'); ?>:
			<?php echo $form->dropDownList($model, 'sex', array(2 => 'Самец', 1 => 'Самка'), array('empty' => 'Не указывать')); ?>
		</div> 
	</div> 

	<div class="row">
		<div class="column">
			<?php echo $form->labelEx($model ,'city'); ?>:
			<?php echo $form->dropDownList($model, 'city', array('Пенза' => 'Пенза', 'Заречный' => 'Заречный'), array('empty' => 'Выберите город')); ?>
		</div>
		<div class="column">
			<div class="group-block" data-form-group="1" style="display:<?php echo ($model->id_category == 1 ? 'block' : 'none');?>">
				<?php echo $form->labelEx($model ,'terms1'); ?>:
				<?php echo $form->dropDownList($model, 'terms1', array(1 => 'с самовыгулом', 2 => 'без самовыгула'), array('empty' => 'Не указывать')); ?>
			</div>
			<div class="group-block" data-form-group="2" style="display:<?php echo ($model->id_category == 2 ? 'block' : 'none');?>">
				<?php echo $form->labelEx($model ,'terms2'); ?>:
				<?php echo $form->dropDownList($model, 'terms2', array(3 => 'будка', 4 => 'дом'), array('empty' => 'Не указывать')); ?>
			</div>
		</div>
	</div>
	
	<div class="row">
		<div class="column">
			<?php echo $form->label($model,'medical'); ?>:
			<?php echo $form->dropDownList($model, 'medical', array(1 => 'Привит', 2 => 'Стерилизован', 3 => 'Привит и стерилизован'), array('empty' => 'Не указывать')); ?>
		</div>
		<div class="column">
			<div class="group-block" data-form-group="1" style="display:<?php echo ($model->id_category == 1 ? 'block' : 'none');?>">
				<?php echo $form->labelEx($model ,'color'); ?>:
				<?php echo $form->textField($model, 'color', array('maxlength' => 256)); ?>
			</div>
			<div class="group-block" data-form-group="2" style="display:<?php echo ($model->id_category == 2 ? 'block' : 'none');?>">
				<?php echo $form->labelEx($model ,'size'); ?>:
				<?php echo $form->textField($model, 'size', array('maxlength' => 256)); ?>
			</div>
		</div>
	</div>
	
	<div class="row wp">
		<?php echo $form->label($model, 'description'); ?>:
		<?php echo $form->textArea($model, 'description', array('rows' => 4)); ?>
	</div>
	
	<div class="row buttons">
		<?php echo CHtml::submitButton('Предложить'); ?>
	</div>

<?php $this->endWidget(); ?>
</div>
<?php endif; ?>