<?php
$this->breadcrumbs=array(
	'Управление Производителями'=>array('index'),
	'Редактирование Производителя '.$model->name,
);
?>
<h1>Редактирование Производителя <?=$model->name;?></h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>