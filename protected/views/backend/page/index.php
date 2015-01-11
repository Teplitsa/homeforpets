<h1>Управление страницами</h1>
<?php echo CHtml::link('+ Добавить страницу', array('/page/create', 'parentId' => $parentId), array('class' => 'add_element')); ?>
<?php $this->widget('ext.plusone.ExtGridView', array(
	'id' => 'page-grid',
	'dataProvider' => $model->search(),
	'filter' => $model,
	'columns' => array(
		array(
			'name' => 'id',
			'filter' => false,
		),
		'link',
		'title',
		array(
			'name' => 'children',
			'filter' => false,
			'type' => 'raw',
			'value' => '(count($data->childs) > 0) ?
				CHtml::link("Список(".count($data->childs).")", array("page/index", "parentId" => $data->id))  :
				CHtml::link("Добавить", array("/page/create", "parentId" => $data->id))'
		),
		array(
			'class' => 'ExtButtonColumn',
		),
	),
	
)); ?>
