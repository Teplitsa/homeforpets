<h1>Управление пунктами меню</h1>
<?php echo CHtml::link('+ Добавить пункт', array('/menuItem/create', 'menuId' => $menu->id, 'parentId' => $model->parent_id), array('class' => 'add_element')); ?>
<?php $this->widget('ext.plusone.ExtGridView', array(
	'id' => 'menu-item-grid',
	'dataProvider' => $model->search(),
	'filter' => $model,
	'columns' => array(
		array(
			'name' => 'id',
			'filter' => false,
		),
		'title',
		'link',
		array(
			'name' => 'children',
			'filter' => false,
			'type' => 'raw',
			'value' => '(count($data->childs) ? 
				CHtml::link("Список(" . count($data->childs) . ")", array("menuItem/index", "menuId" => $data->menu_id, "parentId" => $data->id)) : 
				CHtml::link("Добавить", array("menuItem/create", "menuId" => $data->menu_id, "parentId" => $data->id)))'
		),
		array(
			'class' => 'ExtButtonColumn',
		),
        array(
            'class' => 'ext.SSortable.SSortableColumn',
        ),
	),
)); ?>
