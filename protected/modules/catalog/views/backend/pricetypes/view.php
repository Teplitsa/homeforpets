<?php
$this->breadcrumbs=array(
	'Catalog Pricetypes'=>array('index'),
	$model->name,
);

$this->menu=array(
	array('label'=>'List CatalogPricetypes', 'url'=>array('index')),
	array('label'=>'Create CatalogPricetypes', 'url'=>array('create')),
	array('label'=>'Update CatalogPricetypes', 'url'=>array('update', 'id'=>$model->id)),
	array('label'=>'Delete CatalogPricetypes', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage CatalogPricetypes', 'url'=>array('admin')),
);
?>

<h1>View CatalogPricetypes #<?php echo $model->id; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'id',
		'name',
		'ident_field',
		'price_field',
	),
)); ?>
