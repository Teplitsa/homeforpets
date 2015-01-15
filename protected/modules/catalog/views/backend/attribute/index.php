<?php
$this->breadcrumbs=array(
	'Атрибуты товаров',
);
?>

<h1>Управление атрибутами товаров</h1>

<?php 
echo CHtml::link('+ Добавить атрибут', array('create'), array('class'=>'add_element'));
$this->widget('application.extensions.admingrid.MyRGridView', array(
	'id'=>'catalog-attribute-grid',
	'dataProvider'=>$model->search(),
	'filter'=>$model,
	'columns'=>array(
        'title',
		'name',
		array(
			'name'=>'id_attribute_kind',
			'type'=>'raw',
			'value'=>'$data->kind->title',
			'filter'=>false,
		),
		array(
			'type'=>'raw',
			'value'=>'($data->id_attribute_kind==3 || $data->id_attribute_kind==4) ? CHtml::link(CHtml::encode("Значения"), array("attributeValue/index", "id"=>$data->id)) : ""',
			'filter'=>false,
		),
		//'required',
		array(
			'class'=>'MyRButtonColumn',
			'template' => '{update}{delete}',
		),
        array(
            'class'=>'application.extensions.SSortable.SSortableColumn',
        ),
	),
)); ?>
