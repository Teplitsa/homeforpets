<?php
$this->breadcrumbs=array(
	'Каталог'=>array('/manage/catalog'),
	'Управление отзывами',
);

Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
	$('.search-form').toggle();
	return false;
});
$('.search-form form').submit(function(){
	$.fn.yiiGridView.update('catalog-reviews-grid', {
		data: $(this).serialize()
	});
	return false;
});
");
?>

<h1>Управление отзывами</h1>


<?php //echo CHtml::link('Advanced Search','#',array('class'=>'search-button')); ?>
<!--<div class="search-form" style="display:none">
<?php /*$this->renderPartial('_search',array(
	'model'=>$model,
)); */?>
</div>--><!-- search-form -->

<?php $this->widget('application.extensions.admingrid.MyGridView', array(
	'id'=>'catalog-reviews-grid',
	'dataProvider'=>$model->search(),
	'filter'=>$model,
	'columns'=>array(
		//'id',
		array(
            'name'=>'product_id',
            'header'=>'Наименование товара',
            'type'=>'raw',
            'value'=>'isset($data->product) ? CHtml::link($data->product->title, "/manage/catalog/product/view?id=".$data->product->id) : "Не найден"',
            ),
		array(
            'name'=>'user_id',
            'header'=>'Автор',
            'type'=>'raw',
            'value'=>'isset($data->user) ? CHtml::link($data->user->username, "/manage/user/admin/view?id=".$data->user->id) : "Не найден"',
            ),
		'text',
		'rating',
		array(
            'name'=>'date',
            'value'=>'date("d.m.Y", $data->date)',
            ),
        array(
            'name'=>'published',
            'value'=>'($data->published ? "Да" : "Heт")',
        ),
		array(
			'class'=>'MyButtonColumn',
            'template'=>'{update}{delete}',
		),
	),
)); ?>
