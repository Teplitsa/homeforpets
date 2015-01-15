<?php
$this->breadcrumbs=array(
	'Catalog Attributes'=>array('index'),
	$model->title,
);

$this->menu=array(
	array('label'=>'List CatalogAttribute', 'url'=>array('index')),
	array('label'=>'Create CatalogAttribute', 'url'=>array('create')),
	array('label'=>'Update CatalogAttribute', 'url'=>array('update', 'id'=>$model->id)),
	array('label'=>'Delete CatalogAttribute', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage CatalogAttribute', 'url'=>array('admin')),
);
?>

<h1>View CatalogAttribute #<?php echo $model->id; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'id',
		'title',
		'id_attribute_kind',
		'required',
	),
)); ?>
