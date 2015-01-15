<?php
$this->breadcrumbs=array(
	'Catalog Priceprofiles'=>array('index'),
	$model->name,
);

$this->menu=array(
	array('label'=>'List CatalogPriceprofile', 'url'=>array('index')),
	array('label'=>'Create CatalogPriceprofile', 'url'=>array('create')),
	array('label'=>'Update CatalogPriceprofile', 'url'=>array('update', 'id'=>$model->id)),
	array('label'=>'Delete CatalogPriceprofile', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage CatalogPriceprofile', 'url'=>array('admin')),
);
?>

<h1>View CatalogPriceprofile #<?php echo $model->id; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'id',
		'name',
		'factor',
		'corrector',
	),
)); ?>
