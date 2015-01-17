<?php

Yii::import('zii.widgets.CPortlet');
Yii::import('application.modules.catalog.models.*');
/*
Класс виджета для вывода формы быстрого подбора товаров
*/
class SearchboxWidget extends CPortlet 
{
    public $view = 'searchbox';
    public $params = array();
    public $defaultParams = array(
		'category' => 0,
		'ageFrom' => null,
		'ageFromUnit' => 0,
		'ageTo' => null,
		'ageToUnit' => 0,
		'sex' => 0,
		'city' => 0,
		'color' => 0,
		'size' => 0,
		'medical' => 0,
	);
	
	public function	run() 
	{
		$params = CMap::mergeArray($this->defaultParams, $this->params);
		$colorList = $sizeList = array();
		$colorList = CHtml::listData(Yii::app()->db->createCommand("SELECT DISTINCT(`color`) FROM `catalog_product` WHERE `color` <> '' AND id_category = 1;")->queryAll(), 'color', 'color');
		$sizeList = CHtml::listData(Yii::app()->db->createCommand("SELECT DISTINCT(`size`) FROM `catalog_product` WHERE `size` <> '' AND id_category = 2;")->queryAll(), 'size', 'size');
		
		$this->render($this->view, array(
			'params' => $params,
			'colorList' => $colorList,
			'sizeList' => $sizeList,
        ));
		
		return parent::run();
	}
}
?>
