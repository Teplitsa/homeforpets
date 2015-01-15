<?php
$this->breadcrumbs=array(
    'Загрузка прайс-листа'=>array('loadprice'),
    'Типы прайс-листов'=>array('admin'),
	'Новый тип прайс-листа',
);

?>

<h1>Новый тип прайс-листа</h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>