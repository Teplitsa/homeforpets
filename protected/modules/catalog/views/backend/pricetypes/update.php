<?php
$this->breadcrumbs=array(
    'Загрузка прайс-листа'=>array('loadprice'),
    'Типы прайс-листов'=>array('admin'),
	'Редактирование типа '.$model->name,
);

?>

<h1>Редактирование типа <?php echo $model->name; ?></h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>