<?php
$this->breadcrumbs=array(
	'Управление Производителями'=>array('index'),
	'Добавление Производителя',
);

?>

<h1>Добавление производителя</h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>