<?php
$this->breadcrumbs=array(
	'Характеристики животных'=>array('attribute/index'),
	$attribute->title,
);
?>

<h1>Значения характеристики &laquo;<?php echo $attribute->title;?>&raquo;</h1>

<?php 
echo CHtml::link('+ Добавить значение', array('attributeValue/create', 'id_attribute'=>$attribute->id), array('class'=>'add_element'));
$this->widget('ext.plusone.ExtGridView', array(
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
			'class'=>'ExtButtonColumn',
			'template' => '{update}{delete}',
		),
        array(
            'class'=>'application.extensions.SSortable.SSortableColumn',
        ),
	),
)); ?>
