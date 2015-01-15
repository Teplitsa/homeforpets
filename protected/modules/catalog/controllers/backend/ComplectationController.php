<?php

class ComplectationController extends BackEndController
{

	public function actions()
	{
		return array(
			'move'=>'application.extensions.SSortable.SSortableAction',
            'order' => array(
                'class' => 'ext.RGridView.RGridViewAction',
                'model' => 'CatalogComplectation',
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
	public function actionCreate($product_id)
	{
		$model=new CatalogComplectation;
        $model->product_id=$product_id;
        $model->type=1;
        
        // Делаем хлебные крошки
        $product=CatalogProduct::model()->findByPk($product_id);
        $this->breadcrumbs=CatalogCategory::getParents($product->id_category, true);
		$this->breadcrumbs[$product->title]=array('/catalog/product/view', 'id'=>$product->id);
		$this->breadcrumbs[]='Создание варианта комплектации';

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['CatalogComplectation']))
		{

			$model->attributes=$_POST['CatalogComplectation'];

			if($model->save())
				$this->redirect(array('/catalog/product/view','id'=>$model->product_id));
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
        $product=CatalogProduct::model()->findByPk($model->product_id);
        $this->breadcrumbs=CatalogCategory::getParents($product->id_category, true);
		$this->breadcrumbs[$product->title]=array('/catalog/product/view', 'id'=>$product->id);
		$this->breadcrumbs[]='Редактирование варианта комплектации '.$model->title;

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['CatalogComplectation']))
		{
			$model->attributes=$_POST['CatalogComplectation'];
			if($model->save())
				$this->redirect(array('/catalog/product/view','id'=>$model->product_id));
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
		$dataProvider=new CActiveDataProvider('CatalogComplectation');
		$this->render('index',array(
			'dataProvider'=>$dataProvider,
		));
	}

	/**
	 * Manages all models.
	 */
	public function actionAdmin()
	{
		$model=new CatalogComplectation('search');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['CatalogComplectation']))
			$model->attributes=$_GET['CatalogComplectation'];

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
		$model=CatalogComplectation::model()->findByPk($id);
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
		if(isset($_POST['ajax']) && $_POST['ajax']==='catalog-complectation-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
}
