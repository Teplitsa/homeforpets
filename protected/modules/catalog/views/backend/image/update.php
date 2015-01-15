<?php
$this->breadcrumbs=array(
	'Catalog Images'=>array('index'),
	$model->id=>array('view','id'=>$model->id),
	'Update',
);

$this->menu=array(
	array('label'=>'List CatalogImage', 'url'=>array('index')),
	array('label'=>'Create CatalogImage', 'url'=>array('create')),
	array('label'=>'View CatalogImage', 'url'=>array('view', 'id'=>$model->id)),
	array('label'=>'Manage CatalogImage', 'url'=>array('admin')),
);
?>

<h1>Update CatalogImage <?php echo $model->id; ?></h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>