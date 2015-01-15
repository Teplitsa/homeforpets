<?php

class AttributeController extends BackEndController
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
	public function actionCreate()
	{
		$model=new CatalogAttribute;

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['CatalogAttribute']))
		{
			$model->attributes=$_POST['CatalogAttribute'];
			if($model->save())
			{
				if (isset($_POST['UseCategory']) and $catIds = $_POST['UseCategory'])
				{
					foreach ($catIds as $catId)
						Yii::app()->db->createCommand()->insert('catalog_category_attribute', array('id_category' => $catId, 'id_attribute' => $model->id));
				}
				$this->redirect(array('index'));
			}
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

		if(isset($_POST['CatalogAttribute']))
		{
			$model->attributes=$_POST['CatalogAttribute'];
			if($model->save())
			{
				if (isset($_POST['UseCategory']) and $catIds = $_POST['UseCategory'])
				{
					Yii::app()->db->createCommand()->delete('catalog_category_attribute', 'id_attribute=:id_attribute', array(':id_attribute'=>$model->id));
					foreach ($catIds as $catId)
						Yii::app()->db->createCommand()->insert('catalog_category_attribute', array('id_category' => $catId, 'id_attribute' => $model->id));
				}
				$this->redirect(array('index'));
			}
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
				$this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('index'));
		}
		else
			throw new CHttpException(400,'Invalid request. Please do not repeat this request again.');
	}

	/**
	 * Lists all models.
	 */
	public function actionIndex()
	{
		$model=new CatalogAttribute('search');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['CatalogAttribute']))
			$model->attributes=$_GET['CatalogAttribute'];

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

		$model=CatalogAttribute::model()->findByPk($id);
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
		if(isset($_POST['ajax']) && $_POST['ajax']==='catalog-attribute-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}

    protected function getUseCategories($postUseCategory=array()){
        $use_category=array();
        foreach($postUseCategory as $id_cat){
            $category=CatalogCategory::model()->findByPk($id_cat);
            $use_category[]=$category;
        }

        return $use_category;
    }
}
