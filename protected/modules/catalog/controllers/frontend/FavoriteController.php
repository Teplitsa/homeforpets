<?php

class FavoriteController extends BaseCatalogController
{
	public function actionIndex()
	{
		if (!$ids = $this->getFavIds())
			$ids = 0;
			
		$criteria = new CDbCriteria;
		$criteria->compare('id', $ids);
		$dataProvider = new CActiveDataProvider('CatalogProduct', array(
			'criteria' => $criteria,
			'pagination' => false,
		));
	    if ($this->catalog_config->layout) 
			$this->layout = $this->catalog_config->layout;
       
		$this->render('/default/favorite',array(
			'dataProvider' => $dataProvider,
		));
	}
	
	public function actionAdd($id)
	{
		$ids = $this->getFavIds();
		$ids[] = $id + 0;
		Yii::app()->session['favorite'] = array_unique($ids);
		exit((string)count(array_unique($ids)));
	}
	
	public function actionRemove($id)
	{
		$ids = $this->getFavIds();
		foreach($ids as $key => $value)
			if ($value == $id)
				unset($ids[$key]);
				
		Yii::app()->session['favorite'] = $ids;
		exit((string)count($ids));
	}
	
	private function getFavIds()
	{
		$ids = array();
		if (Yii::app()->session['favorite'] and is_array(Yii::app()->session['favorite']))
			$ids = Yii::app()->session['favorite'];
			
		return $ids;
	}
}