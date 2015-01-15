<?php
$this->breadcrumbs=array(
	'Catalog Reviews'=>array('index'),
	$model->id,
);

$this->menu=array(
	array('label'=>'List CatalogReviews', 'url'=>array('index')),
	array('label'=>'Create CatalogReviews', 'url'=>array('create')),
	array('label'=>'Update CatalogReviews', 'url'=>array('update', 'id'=>$model->id)),
	array('label'=>'Delete CatalogReviews', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage CatalogReviews', 'url'=>array('admin')),
);
?>

<h1>View CatalogReviews #<?php echo $model->id; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'id',
		'product_id',
		'user_id',
		'text',
		'rating',
		'date',
	),
)); ?>
