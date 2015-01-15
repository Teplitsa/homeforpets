<?php
$this->breadcrumbs=array(
	'Catalog Currencys'=>array('index'),
	$model->title,
);

$this->menu=array(
	array('label'=>'List CatalogCurrency', 'url'=>array('index')),
	array('label'=>'Create CatalogCurrency', 'url'=>array('create')),
	array('label'=>'Update CatalogCurrency', 'url'=>array('update', 'id'=>$model->id)),
	array('label'=>'Delete CatalogCurrency', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage CatalogCurrency', 'url'=>array('admin')),
);
?>

<h1>View CatalogCurrency #<?php echo $model->id; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'id',
		'title',
		'cursetorub',
		'prefix',
		'beforeprefix',
		'curseauto',
	),
)); ?>
