<?php

class AttributeValueController extends BackEndController
{
	/**
	 * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
	 * using two-column layout. See 'protected/views/layouts/column2.php'.
	 */
	public $layout='//layouts/column2';

	public function actions()
	{
		return array(
			'move'=>'application.extensions.SSortable.SSortableAction',
            'order' => array(
                'class' => 'ext.RGridView.RGridViewAction',
                'model' => 'CatalogAttributeValue',
                'orderField' => 'sort_order',
            ),
		);
	}
    
	/**
	 * Creates a new model.
	 * If creation is successful, the browser will be redirected to the 'view' page.
	 */
	public function actionCreate($id_attribute)
	{
		$model=new CatalogAttributeValue;
		$model->id_attribute=$id_attribute;
		$attribute=CatalogAttribute::model()->findByPk($id_attribute);

		$this->breadcrumbs=array(
			'Атрибуты товаров'=>array('attribute/index'),
			$attribute->title=>array('attributeValue/index','id'=>$id_attribute),
			'Добавление значения',
			);

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['CatalogAttributeValue']))
		{
			$model->attributes=$_POST['CatalogAttributeValue'];
			if($model->save())
				$this->redirect(array('index','id'=>$model->id_attribute));
		}

		$this->render('create',array(
			'model'=>$model,
			'attribute'=>$attribute,
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
		$attribute=CatalogAttribute::model()->findByPk($model->id_attribute);

		$this->breadcrumbs=array(
			'Атрибуты товаров'=>array('catalogAttribute/index'),
			$attribute->title=>array('attributeValue/index','id'=>$model->id_attribute),
			$model->value,
			'Редактирование',
			);

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['CatalogAttributeValue']))
		{
			$model->attributes=$_POST['CatalogAttributeValue'];
			if($model->save())
				$this->redirect(array('index','id'=>$model->id_attribute));
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
			$model=$this->loadModel($id);
			// we only allow deletion via POST request
			$model->delete();

			// if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
			if(!isset($_GET['ajax']))
				$this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('index', 'id'=>$model->id_attribute));
		}
		else
			throw new CHttpException(400,'Invalid request. Please do not repeat this request again.');
	}

	/**
	 * Lists all models.
	 */
	public function actionIndex($id)
	{
		$model=new CatalogAttributeValue('search');
		$attribute=CatalogAttribute::model()->findByPk($id);
		
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['CatalogAttributeValue']))
			$model->attributes=$_GET['CatalogAttributeValue'];

		$this->render('index',array(
			'model'=>$model,
			'attribute'=>$attribute,
		));
	}

	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param integer the ID of the model to be loaded
	 */
	public function loadModel($id)
	{
		$model=CatalogAttributeValue::model()->findByPk($id);
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
		if(isset($_POST['ajax']) && $_POST['ajax']==='catalog-attribute-value-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
}
