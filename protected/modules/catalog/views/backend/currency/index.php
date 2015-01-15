<?php
$this->breadcrumbs=array(
	'Управление валютами',
);

?>

<h1>Управление валютами</h1>

<? echo CHtml::link('+ Добавить валюту', array('currency/create'), array('class'=>'add_element'));?>
<?php $this->widget('application.extensions.admingrid.MyGridView', array(
	'id'=>'catalog-currency-grid',
	'dataProvider'=>$model->search(),
	'filter'=>$model,
	'columns'=>array(
		'title',
		'cursetorub',
		'prefix',
		array(
			'class'=>'MyButtonColumn',
			'template' => '{update}{delete}',
		),
	),
)); ?>
