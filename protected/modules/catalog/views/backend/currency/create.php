<?php
$this->breadcrumbs=array(
	'Управление валютами'=>array('index'),
	'Добавление валюты',
);

?>

<h1>Добавление валюты</h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>