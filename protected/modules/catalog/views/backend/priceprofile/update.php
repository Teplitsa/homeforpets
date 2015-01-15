<?php
$this->breadcrumbs=array(
	'Ценовые профили'=>array('index'),
	'Редактирование',
);

?>

<h1>Редактирование ценового профиля &laquo;<?php echo $model->name; ?>&raquo;</h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>