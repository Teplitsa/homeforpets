<?php

class BrandsController extends BackEndController
{

	/**
	 * Displays a particular model.
	 * @param integer $id the ID of the model to be displayed
	 */
	public function actionView($id)
	{
		// Берем коллекции бренда
        $collections=new CatalogBrandsCollections();

        $criteria=new CDbCriteria;
		$criteria->compare('brand_id', $id);

        $collectionsProvider=new CActiveDataProvider($collections, array(
			'criteria'=>$criteria,
			'pagination'=>false,
            'sort'=>array(
                'defaultOrder'=>'sort_order',
            ),
		));
		
		$this->render('view',array(
			'model'=>$this->loadModel($id),
			'collections'=>$collectionsProvider,
		));
	}

	/**
	 * Creates a new model.
	 * If creation is successful, the browser will be redirected to the 'view' page.
	 */
	public function actionCreate()
	{
		$model=new CatalogBrands;

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['CatalogBrands']))
		{
			$model->attributes=$_POST['CatalogBrands'];
			if($model->save())
					$this->redirect('index');
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

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['CatalogBrands']))
		{
			$model->attributes=$_POST['CatalogBrands'];
			if($model->save())
				$this->redirect('index');
		}

		$this->render('update',array(
			'model'=>$model,
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
	public function actionIndex()
	{
	    
		$model=new CatalogBrands('search');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['CatalogBrands']))
			$model->attributes=$_GET['CatalogBrands'];

		$this->render('index',array(
			'model'=>$model,
		));
	}

	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param integer the ID of the model to be loaded
	 */
	public function loadModel($id)
	{
		$model=CatalogBrands::model()->findByPk($id);
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
		if(isset($_POST['ajax']) && $_POST['ajax']==='catalog-brands-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
}
