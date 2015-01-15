<?php

class ComplectationValuesController extends BackEndController
{
    
	public function actions()
	{
		return array(
			'move'=>'application.extensions.SSortable.SSortableAction',
            'order' => array(
                'class' => 'ext.RGridView.RGridViewAction',
                'model' => 'CatalogComplectationValues',
                'orderField' => 'sort_order',
            ),
		);
	}

	/**
	 * Displays a particular model.
	 * @param integer $id the ID of the model to be displayed
	 */
	public function actionView($id)
	{
		$this->render('view',array(
			'model'=>$this->loadModel($id),
		));
	}

	/**
	 * Creates a new model.
	 * If creation is successful, the browser will be redirected to the 'view' page.
	 */
	public function actionCreate($complectation_id)
	{
        // Загружаем комплектацию
        $complectation=CatalogComplectation::model()->findByPk($complectation_id);

        // Делаем хлебные крошки
        $product=CatalogProduct::model()->findByPk($complectation->product_id);
        $this->breadcrumbs=CatalogCategory::getParents($product->id_category, true);
		$this->breadcrumbs[$product->title]=array('/catalog/product/view', 'id'=>$product->id);
        $this->breadcrumbs[]='Вариант комплектации '.$complectation->title;
		$this->breadcrumbs[]='Создание значения';

		$model=new CatalogComplectationValues;

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['CatalogComplectationValues']))
		{
			$model->attributes=$_POST['CatalogComplectationValues'];
            $model->complectation_id=$complectation_id;
			if($model->save())
				$this->redirect(array('index','complectation_id'=>$model->complectation_id));
		}

		$this->render('create',array(
			'model'=>$model,
		));
	}

	/**
	 * Updates a particular model.
	 * If update is successful, the browser will be redirected to the 'view' page.
	 * @param integer $id the ID of the model to be updated
	 */
	public function actionUpdate($id)
	{
		$model=$this->loadModel($id);

        // Загружаем комплектацию
        $complectation=CatalogComplectation::model()->findByPk($model->complectation_id);

        // Делаем хлебные крошки
        $product=CatalogProduct::model()->findByPk($complectation->product_id);
        $this->breadcrumbs=CatalogCategory::getParents($product->id_category, true);
		$this->breadcrumbs[$product->title]=array('/catalog/product/view', 'id'=>$product->id);
        $this->breadcrumbs[]='Вариант комплектации '.$complectation->title;
		$this->breadcrumbs[]='Редактирование значения';
        
		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['CatalogComplectationValues']))
		{
			$model->attributes=$_POST['CatalogComplectationValues'];
			if($model->save())
				$this->redirect(array('index','complectation_id'=>$model->complectation_id));
		}

		$this->render('update',array(
			'model'=>$model,
            'complectation'=>$complectation,
		));
	}

	/**
	 * Deletes a particular model.
	 * If deletion is successful, the browser will be redirected to the 'admin' page.
	 * @param integer $id the ID of the model to be deleted
	 */
	public function actionDelete($id)
	{
		if(Yii::app()->request->isPostRequest)
		{
			// we only allow deletion via POST request
			$this->loadModel($id)->delete();

			// if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
			if(!isset($_GET['ajax']))
				$this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('admin'));
		}
		else
			throw new CHttpException(400,'Invalid request. Please do not repeat this request again.');
	}


	/**
	 * Manages all models.
	 */
	public function actionIndex($complectation_id)
	{
        // Загружаем комплектацию
        $complectation=CatalogComplectation::model()->findByPk($complectation_id);

        // Делаем хлебные крошки
        $product=CatalogProduct::model()->findByPk($complectation->product_id);
        $this->breadcrumbs=CatalogCategory::getParents($product->id_category, true);
		$this->breadcrumbs[$product->title]=array('/catalog/product/view', 'id'=>$product->id);
        $this->breadcrumbs[]='Значения варианта комплектации '.$complectation->title;

		$model=new CatalogComplectationValues();

        $criteria=new CDbCriteria;
		$criteria->compare('complectation_id', $complectation_id);

        $valuesProvider=new CActiveDataProvider($model, array(
			'criteria'=>$criteria,
            'sort'=>array(
                'defaultOrder'=>'sort_order',
            ),
		));

		$this->render('index',array(
            'complectation'=>$complectation,
			'valuesProvider'=>$valuesProvider,
		));
	}

	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param integer the ID of the model to be loaded
	 */
	public function loadModel($id)
	{
		$model=CatalogComplectationValues::model()->findByPk($id);
		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}

	/**
	 * Performs the AJAX validation.
	 * @param CModel the model to be validated
	 */
	protected function performAjaxValidation($model)
	{
		if(isset($_POST['ajax']) && $_POST['ajax']==='catalog-complectation-values-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
}
