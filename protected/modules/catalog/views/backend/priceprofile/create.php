<?php
$this->breadcrumbs=array(
	'Ценовые профили'=>array('index'),
	'Добавление',
);

?>

<h1>Добавление ценового профиля</h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>