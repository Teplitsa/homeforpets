<?php
$this->breadcrumbs=array(
	'Catalog Images'=>array('index'),
	$model->id,
);

$this->menu=array(
	array('label'=>'List CatalogImage', 'url'=>array('index')),
	array('label'=>'Create CatalogImage', 'url'=>array('create')),
	array('label'=>'Update CatalogImage', 'url'=>array('update', 'id'=>$model->id)),
	array('label'=>'Delete CatalogImage', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage CatalogImage', 'url'=>array('admin')),
);
?>

<h1>View CatalogImage #<?php echo $model->id; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'id',
		'id_product',
		'image',
	),
)); ?>
