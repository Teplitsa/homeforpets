<?php
$this->breadcrumbs = array(
	'Управление меню' => array('index'),
	$model->title . ' (редактирование)',
);
?>
<h1>Редактирование меню</h1>
<?php echo $this->renderPartial('_form', array('model' => $model)); ?>