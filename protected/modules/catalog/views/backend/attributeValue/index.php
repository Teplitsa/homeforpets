<?php
$this->breadcrumbs=array(
	'Атрибуты товаров'=>array('attribute/index'),
	$attribute->title,
);
?>

<h1>Значения атрибута &laquo;<?php echo $attribute->title;?>&raquo;</h1>

<?php 
echo CHtml::link('+ Добавить значение', array('attributeValue/create', 'id_attribute'=>$attribute->id), array('class'=>'add_element'));
$this->widget('application.extensions.admingrid.MyRGridView', array(
	'id'=>'catalog-attribute-value-grid',
	'dataProvider'=>$model->search(),
	'filter'=>$model,
	'columns'=>array(
		array(
			'name'=>'id',
			'filter'=>false,
		),
		'value',
		array(
			'class'=>'MyRButtonColumn',
			'template' => '{update}{delete}',
		),
        array(
            'class'=>'application.extensions.SSortable.SSortableColumn',
        ),
	),
)); ?>
