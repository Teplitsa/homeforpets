<?php
$this->breadcrumbs=array(
	'Атрибуты товаров'=>array('index'),
	$model->title,
	'Редактирование',
);
?>

<h1>Редактирование атрибута &laquo;<?php echo $model->title; ?>&raquo;</h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>