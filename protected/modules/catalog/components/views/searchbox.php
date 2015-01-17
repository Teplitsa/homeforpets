<?php
Yii::app()->clientScript->registerScript('search-pets',"

	$(document).on('change', 'select.form-group', function() {
		var group = $(this).val();
		if (!group)
			group = 0;
			
		$('div.group-block[data-form-group]').hide();
		$('div.group-block[data-form-group ~= '+group+']').show();
	});
	
	$(document).on('click', '.check-all', function(){
		var name = $(this).data('param');
		$('input[id ^= params_'+name+']').prop('disabled', $(this).prop('checked'));
	});
 
", CClientScript::POS_READY);
?>
<?php $form = $this->beginWidget('CActiveForm', array(
	'id' => 'seacrh-form',
    'action' => '/catalog/default/selection',
    'method' => 'get',
)); ?>
<div class="s-form">
	<div class="row">
		<h1>Подобрать животное</h1>
	</div>
	<div class="row">
		<div class="column">
			<?php echo CHtml::label('Вид животного', 'params[category]'); ?>:
			<?php echo CHtml::dropDownList('params[category]', $params['category'], CHtml::listData(CatalogCategory::model()->findAll('parent_id = 0'), 'id', 'title'), array('empty' => 'Любое животное', 'class' => 'form-group')); ?>
		</div>
		<div class="column mh">
			<?php echo CHtml::label('Возраст', 'params[ageFrom]'); ?>:
			<div class="column-left">
				<?php echo CHtml::textField('params[ageFrom]', $params['ageFrom'], array('maxlength' => 256, 'placeholder' => 'от')); ?>
				<?php echo CHtml::dropDownList('params[ageFromUnit]', $params['ageFromUnit'], array(7 => 'Недель', 30 => 'Месяцев', 365 => 'Лет')); ?>
			</div>
			<div class="column-right">
				<?php echo CHtml::textField('params[ageTo]', $params['ageTo'], array('maxlength' => 256, 'placeholder' => 'до')); ?>
				<?php echo CHtml::dropDownList('params[ageToUnit]', $params['ageToUnit'], array(7 => 'Недель', 30 => 'Месяцев', 365 => 'Лет')); ?>
			</div>
		</div>
	</div>
	
	<div class="row">
		<div class="column">
			<?php echo CHtml::label('Пол', 'params[sex]'); ?>:<br/>
			<?php echo CHtml::dropDownList('params[sex]', $params['sex'], array(1 => 'Самка', 2 => 'Самец'), array('empty' => 'Все')); ?>
		</div>
		<div class="column">
			<?php echo CHtml::label('Город', 'params[city]'); ?>:<br/>
			<?php echo CHtml::dropDownList('params[city]', $params['city'], array('Пенза' => 'Пенза', 'Заречный' => 'Заречный'), array('empty' => 'Все')); ?>
		</div>
	</div>
	
	<div class="row">
		<div class="column">
			<div class="group-block" data-form-group="1" style="display:<?php echo ($params['category'] == 1 ? 'block' : 'none');?>">
				<?php echo CHtml::label('Цвет(Окрас)', 'params[color]'); ?>:<br/>
				<?php echo CHtml::checkBoxList('params[color][]', $params['color'], $colorList, array('separator' => '', 'template' => '<span class="did">{input} {label}</span>')); ?>
				<span class="did">	
					<?php echo CHtml::checkBox('check-all-color', 0, array('class' => 'check-all', 'data-param' => 'color')); ?>
					<?php echo CHtml::label('Все', 'check-all-color'); ?>
				</span>
			</div>
			<div class="group-block" data-form-group="2" style="display:<?php echo ($params['category'] == 2 ? 'block' : 'none');?>">
				<?php echo CHtml::label('Размер', 'params[size]'); ?>:<br/>
				<?php echo CHtml::checkBoxList('params[size][]', $params['size'], $sizeList, array('separator' => '', 'template' => '<span class="did">{input} {label}</span>')); ?>
				<span class="did">
					<?php echo CHtml::checkBox('check-all-size', 0, array('class' => 'check-all', 'data-param' => 'size')); ?>
					<?php echo CHtml::label('Все', 'check-all-size'); ?>
				</span>
			</div>
		</div>
		<div class="column">
			<div class="group-block" data-form-group="1 2" style="display:<?php echo ($params['category'] == 1 ? 'block' : 'none');?>">
				<?php echo CHtml::label('Стерилизация и прививки', 'params[medical]'); ?>:<br/>
				<?php echo CHtml::checkBoxList('params[medical][]', $params['medical'], array(1 => 'Привит', 2 => 'Стерилизован', 3 => 'Привит и стерилизован'), array('separator' => '', 'template' => '<span class="did">{input} {label}</span>')); ?>
			</div>
		</div>
	</div>
	
	<div class="row buttons">
		<?php echo CHtml::submitButton('Подобрать'); ?>
	</div>
</div>
<?php $this->endWidget(); ?>