<?php
    $this->breadcrumbs = array(
        'Управление блоками' => array('index'),
        'Редактирование области вывода ' . $model->title,
    );

?>

<h1>Редактирование области вывода <?php echo $model->title; ?></h1>

<?php echo $this->renderPartial('_form', array('model' => $model)); ?>