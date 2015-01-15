<?php
$cs=Yii::app()->clientScript;

// Показать-скрыть
$cs->registerScript('showhide', "
  $('a.showhide').click(function(){
      if ( $(this).next().css('display') == 'none' ) {
            $(this).next().animate({height: 'show'}, 400);
            $(this).text('Скрыть');
      } else {
            $(this).next().animate({height: 'hide'}, 200);
            $(this).text('Показать');
      }
		return false;
	});
", CClientScript::POS_READY);

$this->breadcrumbs=array(
	'Управление Производителями'=>array('index'),
	'Просмотр Производителя '.$model->name,
);
?>

<h1><?php echo $model->name;?></h1>
<?echo CHtml::link('Редактировать Производителя', array('update', 'id'=>$model->id), array('class'=>'add_element'));?><br/>

<?php if($model->image):?>
<div class="logotype">
    <?php echo CHtml::image('/upload/catalog/brand/' . $model->image, $model->name);?>
</div>
<br/>
<?endif;?>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'htmlOptions'=>array('class'=>'viewinfo'),
	'attributes'=>array(
		'name',
		'country',
	),
)); ?>

<!--h3>Коллекции</h3-->
<?/*php
echo CHtml::link('+ Добавить коллекцию', array('brandsCollections/create', 'brand_id'=>$model->id), array('class'=>'add_element'));
$this->widget('application.extensions.admingrid.MyRGridView', array(
	'id'=>'catalog-collections-grid',
	'dataProvider'=>$collections,
    'orderUrl'=>array('/manage/catalog/brandsCollections/order'),
	'columns'=>array(
		'name',
		array(
			'class'=>'MyRButtonColumn',
			'template' => '{update}{delete}',
			'buttons'=>array
			(
				'update' => array
				(
					'imageUrl'=>Yii::app()->request->baseUrl.'/images/admin/edit.png',
					'url'=>'Yii::app()->createUrl("catalog/brandsCollections/update", array("id" => $data->id))',
				),
				'delete' => array
				(
					'imageUrl'=>Yii::app()->request->baseUrl.'/images/admin/del.png',
					'url'=>'Yii::app()->createUrl("catalog/brandsCollections/delete", array("id" => $data->id))',
				),
			),

		),
        array(
            'class'=>'application.modules.catalog.components.SSortable.BrandsCollectionsSSortableColumn',
        ),
	),
)); */?>


<?php if($model->text):?>
<h3>Описание</h3>
<a href="#" class="showhide">Показать</a>
<div style="display: none;"><?=$model->text;?></div>
<?endif;?>