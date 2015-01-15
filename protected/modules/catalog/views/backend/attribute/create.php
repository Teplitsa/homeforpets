<?php
$this->breadcrumbs=array(
	'Атрибуты товаров'=>array('index'),
	'Добавление атрибута',
);
?>

<h1>Добавление атрибута товаров</h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>