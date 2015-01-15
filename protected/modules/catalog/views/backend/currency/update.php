<?php
$this->breadcrumbs=array(
	'Управление валютами'=>array('index'),
	'Редактирование валюты '.$model->title,
);

?>

<h1>Редактирование валюты &laquo;<?php echo $model->title; ?>&raquo;</h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>