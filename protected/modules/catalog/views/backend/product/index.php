<?php
$this->breadcrumbs=array(
	'Catalog Products',
);

$this->menu=array(
	array('label'=>'Create CatalogProduct', 'url'=>array('create')),
	array('label'=>'Manage CatalogProduct', 'url'=>array('admin')),
);
?>

<h1>Catalog Products</h1>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
