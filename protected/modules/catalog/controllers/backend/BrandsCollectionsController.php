<?php

class BrandsCollectionsController extends BackEndController
{
	public function actions()
	{
		return array(
			'move'=>'application.extensions.SSortable.SSortableAction',
            'order' => array(
                'class' => 'ext.RGridView.RGridViewAction',
                'model' => 'CatalogBrandsCollections',
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
	public function actionCreate($brand_id)
	{
		$model=new CatalogBrandsCollections;
		
		$model->brand_id=$brand_id;
		// Делаем хлебные крошки
        $brand=CatalogBrands::model()->findByPk($brand_id);
        $this->breadcrumbs['Управление брендами']=array('/catalog/brands/index');
		$this->breadcrumbs[$brand->name]=array('/catalog/brands/view', 'id'=>$brand->id);
		$this->breadcrumbs[]='Добавление коллекции';

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['CatalogBrandsCollections']))
		{
			$model->attributes=$_POST['CatalogBrandsCollections'];
			if($model->save())
				$this->redirect(array('/catalog/brands/view','id'=>$brand_id));
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
		
		// Делаем хлебные крошки
        $brand=CatalogBrands::model()->findByPk($model->brand_id);
        $this->breadcrumbs['Управление брендами']=array('/catalog/brands/index');
		$this->breadcrumbs[$brand->name]=array('/catalog/brands/view', 'id'=>$brand->id);
		$this->breadcrumbs[]='Редактирование коллекции';

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['CatalogBrandsCollections']))
		{
			$model->attributes=$_POST['CatalogBrandsCollections'];
			if($model->save())
				$this->redirect(array('/catalog/brands/view','id'=>$brand->id));
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
	 * Lists all models.
	 */
	public function actionIndex()
	{
		$dataProvider=new CActiveDataProvider('CatalogBrandsCollections');
		$this->render('index',array(
			'dataProvider'=>$dataProvider,
		));
	}

	/**
	 * Manages all models.
	 */
	public function actionAdmin()
	{
		$model=new CatalogBrandsCollections('search');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['CatalogBrandsCollections']))
			$model->attributes=$_GET['CatalogBrandsCollections'];

		$this->render('admin',array(
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
		$model=CatalogBrandsCollections::model()->findByPk($id);
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
		if(isset($_POST['ajax']) && $_POST['ajax']==='catalog-brands-collections-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
}
