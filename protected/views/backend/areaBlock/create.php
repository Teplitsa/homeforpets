<?php
    $this->breadcrumbs = array(
        'Управление блоками' => array('area/index'),
        'Создание блока',
);

?>

<h1>Создание блока</h1>

<?=$this->renderPartial('_form', array('model' => $model)); ?>