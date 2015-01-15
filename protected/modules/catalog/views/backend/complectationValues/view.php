<?php
$this->breadcrumbs=array(
	'Catalog Complectation Values'=>array('index'),
	$model->id,
);

$this->menu=array(
	array('label'=>'List CatalogComplectationValues', 'url'=>array('index')),
	array('label'=>'Create CatalogComplectationValues', 'url'=>array('create')),
	array('label'=>'Update CatalogComplectationValues', 'url'=>array('update', 'id'=>$model->id)),
	array('label'=>'Delete CatalogComplectationValues', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage CatalogComplectationValues', 'url'=>array('admin')),
);
?>

<h1>View CatalogComplectationValues #<?php echo $model->id; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'id',
		'complectation_id',
		'value',
		'price_correction',
		'correction_type',
	),
)); ?>
