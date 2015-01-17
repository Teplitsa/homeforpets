<?php

Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
	$('.search-form').toggle();
	return false;
});

");
Yii::app()->clientScript->registerScript('publicate', "
$(document).on('click','#products-grid .yamarket',function() {
	$.ajax({
		type:'POST',
		url:'/manage/catalog/product/publicate',
		data: {id:$(this).data('id'),yam:$(this).prop('checked')},
		success:function() {
			$.fn.yiiGridView.update('products-grid');
		}
	});
	return true;
});

$(document).on('click','#products-grid .hider',function() {
	$.ajax({
		type:'POST',
		url:'/manage/catalog/product/publicate',
		data: {id:$(this).data('id'),hide:$(this).prop('checked')},
		success:function() {
			$.fn.yiiGridView.update('products-grid');
		}
	});
	return true;
});
$('.delete').click(function(){
  var h = $(this).attr('href');
  var reg = /\d+$/;
  var res= reg.exec(h);


  if(res!=null)
  {
   var needed ='index?id='+res[0];
    if($('.items a.category[href*=\''+needed+'\']').text() !='')
    {
    alert('Ошибка , нельзя удалить категорию с подкатегориями!')
     return false;
    }

  }

   });

");
?>
<h1><?php echo $category->title;?></h1>
<?/*
<div class="advanced_search">
    <?php echo CHtml::link('Расширенный поиск','#',array('class'=>'search-button')); ?>
    <div class="search-form" style="display:none">
        <p>
            Можно ввести опреатор сравнения (<b>&lt;</b>, <b>&lt;=</b>, <b>&gt;</b>, <b>&gt;=</b>, <b>&lt;&gt;</b>
            или <b>=</b>) в начале значений.
        </p>

        <?php $this->renderPartial('_search',array(
        'model'=>$products,
    )); ?>
    </div><!-- search-form -->
</div>
*/?>
<?php if (!$category->id): ?>
<div class="block">
<h2>Список категорий</h2>
<?php
	//echo CHtml::link('+ Добавить подкатегорию', array('default/create', 'id'=>$category->id), array('class'=>'add_element'));
	$this->widget('ext.plusone.ExtGridView', array(
		'id' => 'category-grid',
		'dataProvider' => $categoryDataProvider,
		'emptyText' => 'Нет категорий',
		'columns' => array(
			array(
				'name'=>'title',
				'type'=>'raw',
				'value'=>'CHtml::link(CHtml::encode($data->title), array("index", "id"=>$data->id))'
			),
			array(
				'header' => 'Животные',
				'type' => 'raw',
				'value' => 'CHtml::link("Список(" . count($data->productsAttached) . ")", array("index", "id" => $data->id),array("class"=>"category"))',
			),
		),
	)); 

?>
</div>
<?php else: ?>
<h2>Список животных</h2>
<?php
$this->widget('ext.plusone.ExtGridView', array(
	'id'=>'products-grid',
	'dataProvider'=>$products->search(),
	'filter'=>$products,
	'emptyText'=>'Нет животных в данной категории',
	'columns'=>array(
		array(
			'name'=>'id',
			'filter'=>false,
		),
/*		array(
			'name'=>'number',
			'type'=>'raw',
			'filter'=>false,
			'value'=>'CHtml::link(CHtml::encode($data->number), array("catalogProduct/update", "id"=>$data->id))'
		),*/
		array(
			'name'=>'title',
			'type'=>'raw',
			'value'=>'CHtml::link(CHtml::encode($data->title), array("product/view", "id"=>$data->id))'
		),
		/* array(
			'header'=>'ЯМаркет',
			'type'=>'raw',
			'value'=>'CHtml::checkBox("yam",!$data->noyml,array("class"=>"yamarket","data-id"=>$data->id))'
		),
		*/
		array(
			'class'=>'ExtButtonColumn',
			'buttons'=>array
			(
				'update' => array
				(
					'imageUrl'=>Yii::app()->request->baseUrl.'/images/admin/edit.png',
					'url'=>'Yii::app()->createUrl("catalog/product/update", array("id" => $data->id))',
				),
				'delete' => array
				(
					'imageUrl'=>Yii::app()->request->baseUrl.'/images/admin/del.png',
					'url'=>'Yii::app()->createUrl("catalog/product/delete", array("id" => $data->id))',
				),
			),

		),
	),
)); 

?>


<? endif; ?>

