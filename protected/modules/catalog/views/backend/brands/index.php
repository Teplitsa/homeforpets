<?php
$this->breadcrumbs=array(
	'Управление Производителями',
);
?>
<h1>Управление Производителями</h1>

<?php
echo CHtml::link('+ Добавить Производителя', array('create'), array('class'=>'add_element'));
$this->widget('application.extensions.admingrid.MyGridView', array(
	'id'=>'catalog-brand-grid',
	'dataProvider'=>$model->search(),
	'filter'=>$model,
	'columns'=>array(
		array(
			'name'=>'name',
			'type'=>'raw',
			'value'=>'CHtml::link(CHtml::encode($data->name), array("update", "id"=>$data->id))'
		),
		//'country',
		array(
			'class'=>'MyButtonColumn',
			'template' => '{update}{delete}',
		),
	),
)); ?>
