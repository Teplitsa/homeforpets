<?php
$this->breadcrumbs=array(
	'Характеристики животных'=>array('index'),
	$model->title,
	'Редактирование',
);
?>

<h1>Редактирование характеристики &laquo;<?php echo $model->title; ?>&raquo;</h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>