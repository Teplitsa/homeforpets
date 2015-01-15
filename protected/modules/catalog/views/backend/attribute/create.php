<?php
$this->breadcrumbs=array(
	'Характеристики животных'=>array('index'),
	'Добавление характеристики',
);
?>

<h1>Добавление характеристики животных</h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>