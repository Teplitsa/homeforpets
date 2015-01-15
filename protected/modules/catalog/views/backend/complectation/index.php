<?php
$this->breadcrumbs=array(
	'Catalog Complectations',
);

$this->menu=array(
	array('label'=>'Create CatalogComplectation', 'url'=>array('create')),
	array('label'=>'Manage CatalogComplectation', 'url'=>array('admin')),
);
?>

<h1>Catalog Complectations</h1>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
