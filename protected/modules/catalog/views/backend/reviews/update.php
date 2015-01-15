<?php
$this->breadcrumbs=array(
    'Каталог'=>array('/manage/catalog'),
	'Управление отзывами'=>array('index'),
	'Редактирование отзыва',
);

?>

<h1>Редактирование отзыва </h1>
<p>Товар - <?php echo CHtml::link($model->product->title, '/manage/catalog/product/view?id='.$model->product->id); ?></p>
<p>Пользователь - <?php echo CHtml::link($model->user->username, '/manage/user/admin/view?id='.$model->user->id); ?></p>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>