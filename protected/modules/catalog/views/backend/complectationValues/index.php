
<h1>Значения варианта комплектации &laquo;<?=$complectation->title;?>&raquo;</h1>

<?php
echo CHtml::link('+ Добавить значение', array('complectationValues/create', 'complectation_id'=>$complectation->id), array('class'=>'add_element'));
$this->widget('application.extensions.admingrid.MyRGridView', array(
	'id'=>'catalog-complectation-values-grid',
	'dataProvider'=>$valuesProvider,
	'columns'=>array(
		'value',
		'article',
        array(
            'name'=>'correction_type',
            'value'=>'isset($data->correctionTypes["$data->correction_type"]) ? $data->correctionTypes["$data->correction_type"] : "Не установлен"',
        ),
        array(
            'header'=>'Величина коррекции цены',
            'type'=>'raw',
            'value'=>'$data->outPriceCorrection("{price}",0)',
        ),
		array(
			'class'=>'MyRButtonColumn',
			'template' => '{update}{delete}',
			'buttons'=>array
			(
				'update' => array
				(
					'imageUrl'=>Yii::app()->request->baseUrl.'/images/admin/edit.png',
					'url'=>'Yii::app()->createUrl("catalog/complectationValues/update", array("id" => $data->id))',
				),
				'delete' => array
				(
					'imageUrl'=>Yii::app()->request->baseUrl.'/images/admin/del.png',
					'url'=>'Yii::app()->createUrl("catalog/complectationValues/delete", array("id" => $data->id))',
				),
			),

		),
        array(
            'class'=>'application.extensions.SSortable.SSortableColumn',
        ),
	),
));
echo CHtml::link('<< Вернуться к просмотру товара', array('/catalog/product/view', 'id'=>$complectation->product_id), array('class'=>'add_element'));
?>
