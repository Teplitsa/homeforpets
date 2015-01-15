<?php
$this->breadcrumbs=array(
	'Каталог'=>array('/catalog'),
	'Поиск',
);

$this->menu=array(
	array('label'=>'List CatalogProduct', 'url'=>array('index')),
	array('label'=>'Create CatalogProduct', 'url'=>array('create')),
);

Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
	$('.search-form').toggle();
	return false;
});
$('.search-form form').submit(function(){
	$.fn.yiiGridView.update('catalog-product-grid', {
		data: $(this).serialize()
	});
	return false;
});
");

// Цепляем плагин "Редактирования на месте"
Yii::app()->clientScript->registerScriptFile('/js/jquery.jeditable.js');

// Скрипт редактирования на месте цены
$func =<<< EOD
		function() {

     $('.editableprice').editable('/manage/catalog/product/editprice', {
         id   : 'elementid',
         type      : 'text',
         cancel    : false,
         submit    : 'Ok',
         indicator : '<img src=\"/css/loading.gif\"/>',
         tooltip   : 'Кликните для редактирования...'
     });

		}
EOD;
Yii::app()->clientScript->registerScript('editprice', "
     $('.editableprice').editable('/manage/catalog/product/editprice', {
         id   : 'elementid',
         type      : 'text',
         cancel    : false,
         submit    : 'Ok',
         indicator : '<img src=\"/css/loading.gif\"/>',
         tooltip   : 'Кликните для редактирования...'
     });
", CClientScript::POS_READY);

Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
	$('.search-form').toggle();
	return false;
});

");

?>

<h1>Поиск товаров</h1>

<?php echo CHtml::link('Расширенный поиск','#',array('class'=>'search-button')); ?>
<div class="search-form" style="display:block">
    <p>
        Можно ввести опреатор сравнения (<b>&lt;</b>, <b>&lt;=</b>, <b>&gt;</b>, <b>&gt;=</b>, <b>&lt;&gt;</b>
        или <b>=</b>) в начале значений.
    </p>
<?php $this->renderPartial('_search',array(
	'model'=>$model,
)); ?>
</div><!-- search-form -->

<?php $this->widget('ext.admingrid..MyGridView', array(
	'id'=>'catalog-product-grid',
	'dataProvider'=>$model->search(),
	'filter'=>$model,
    'afterAjaxUpdate'=>$func,
	'columns'=>array(
		//'id',
        array(
            'name'=>'id_category',
            'type'=>'raw',
            'value'=>'CHtml::link(CHtml::encode($data->idCategory->title), array("/manage/catalog/default/index?id=".$data->idCategory->id))',
        ),
        array(
            'name'=>'title',
            'type'=>'raw',
            'value'=>'CHtml::link(CHtml::encode($data->title), array("product/view", "id"=>$data->id))'
        ),
        array(
            'name'=>'price',
            'type'=>'raw',
            'filter'=>false,
            'value'=>'$data->price." руб."',
        ),

		/*
		'on_main',
		*/
		array(
			'class'=>'MyButtonColumn',
		),
	),
)); ?>
