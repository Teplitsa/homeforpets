<?php
$this->breadcrumbs=array(
	'Catalog Complectations'=>array('index'),
	$model->name,
);

$this->menu=array(
	array('label'=>'List CatalogComplectation', 'url'=>array('index')),
	array('label'=>'Create CatalogComplectation', 'url'=>array('create')),
	array('label'=>'Update CatalogComplectation', 'url'=>array('update', 'id'=>$model->id)),
	array('label'=>'Delete CatalogComplectation', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage CatalogComplectation', 'url'=>array('admin')),
);
?>

<h1>View CatalogComplectation #<?php echo $model->id; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'id',
		'name',
		'title',
		'type',
		'value',
		'product_id',
	),
)); ?>
