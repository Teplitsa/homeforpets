<?php
    $this->breadcrumbs=array(
        'Управление блоками' => array('index'),
        'Создание области вывода',
    );


?>

<h1>Создание области вывода</h1>

<?php echo $this->renderPartial('_form', array('model' => $model)); ?>