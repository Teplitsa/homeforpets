<?php
$this->breadcrumbs = array(
	'Управление меню' => array('index'),
	'Добавление меню',
);
?>
<h1>Добавление меню</h1>
<?php echo $this->renderPartial('_form', array('model' => $model)); ?>