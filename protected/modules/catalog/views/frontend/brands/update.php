<?php
$this->breadcrumbs=array(
	'Управление брендами'=>array('index'),
	'Редактирование бренда '.$model->name,
);
?>
<h1>Редактирование бренда <?=$model->name;?></h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>