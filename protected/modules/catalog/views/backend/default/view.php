<?php
$this->breadcrumbs=array(
	'Catalog Categories'=>array('index'),
	$model->title,
);

$this->menu=array(
	array('label'=>'List CatalogCategory', 'url'=>array('index')),
	array('label'=>'Create CatalogCategory', 'url'=>array('create')),
	array('label'=>'Update CatalogCategory', 'url'=>array('update', 'id'=>$model->id)),
	array('label'=>'Delete CatalogCategory', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage CatalogCategory', 'url'=>array('admin')),
);
?>

<h1>View CatalogCategory #<?php echo $model->id; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'id',
		'title',
		'link',
		'image',
	),
)); ?>
