<?php
$this->breadcrumbs=array(
	'Catalog Images',
);

$this->menu=array(
	array('label'=>'Create CatalogImage', 'url'=>array('create')),
	array('label'=>'Manage CatalogImage', 'url'=>array('admin')),
);
?>

<h1>Catalog Images</h1>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
