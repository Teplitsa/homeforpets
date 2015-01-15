<?php
$this->breadcrumbs=array(
	'Ценовые профили',
);


?>

<h1>Управление ценовыми профилями</h1>

<? echo CHtml::link('+ Добавить ценовой профиль', array('priceprofile/create'), array('class'=>'add_element'));?>
<?php $this->widget('application.extensions.admingrid.MyGridView', array(
	'id'=>'catalog-priceprofile-grid',
	'dataProvider'=>$model->search(),
	'filter'=>$model,
	'columns'=>array(
		'name',
		'factor',
		'corrector',
		array(
			'class'=>'MyButtonColumn',
			'template' => '{update}{delete}',
		),
	),
)); ?>
