<?php
$this->breadcrumbs=array(
	'Catalog Images'=>array('index'),
	'Create',
);

$this->menu=array(
	array('label'=>'List CatalogImage', 'url'=>array('index')),
	array('label'=>'Manage CatalogImage', 'url'=>array('admin')),
);
?>

<h1>Create CatalogImage</h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>