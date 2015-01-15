<?php
$this->breadcrumbs=array(
    'Каталог'=>array('/manage/catalog'),
    'Управление отзывами'=>array('index'),
    'Добавление отзыва',
);

?>

<h1>Добавление отзыва</h1>
<p>Товар - <?php echo CHtml::link($product->title, '/manage/catalog/product/view?id='.$product->id); ?></p>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>