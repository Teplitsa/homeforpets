<?php
$this->breadcrumbs = array(
	'Управление меню',
);
?>
<h1>Управление меню</h1>
<?php echo CHtml::link('+ Добавить меню', array('/menu/create'), array('class' => 'add_element')); ?>
<?php $this->widget('ext.plusone.ExtGridView', array(
	'id' => 'menu-grid',
	'dataProvider' => $model->search(),
	'filter' => $model,
	'columns' => array(
		array(
			'name' => 'id',
			'filter' => false,
		),
		'title',
		'name',
		array(
			'header' => 'Пункты меню',
			'type' => 'raw',
			'value' => 'count($data->items) ?
				CHtml::link("Список(" . count($data->items) . ")", array("menuItem/index", "menuId" => $data->id)) :
				CHtml::link("Добавить", array("menuItem/create", "menuId" => $data->id))'
		),
		array(
			'class' => 'ExtButtonColumn',
		),
	),
)); ?>
