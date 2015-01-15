<?php
$this->breadcrumbs=array(
	'Catalog Pricetypes',
);

$this->menu=array(
	array('label'=>'Create CatalogPricetypes', 'url'=>array('create')),
	array('label'=>'Manage CatalogPricetypes', 'url'=>array('admin')),
);
?>

<h1>Catalog Pricetypes</h1>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
