<?php

class ReviewsController extends BackEndController
{


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
		$model=new CatalogReviews;

        $product=CatalogProduct::model()->findByPk($product_id);

        $model->product_id=$product_id;
        $model->published=1;

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['CatalogReviews']))
		{
			$model->attributes=$_POST['CatalogReviews'];
			if($model->save())
				//$this->redirect(array('view','id'=>$model->id));
                $this->redirect(Yii::app()->user->returnUrl);
		}

		$this->render('create',array(
			'model'=>$model,
            'product'=>$product,
		));
	}

	/**
	 * Updates a particular model.
	 * If update is successful, the browser will be redirected to the 'view' page.
	 * @param integer $id the ID of the model to be updated
	 */
	public function actionUpdate($id)
	{
        Yii::import('application.modules.user.models.User');

		$model=$this->loadModel($id);

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['CatalogReviews']))
		{
			$model->attributes=$_POST['CatalogReviews'];
			if($model->save())
				//$this->redirect('index');
                $this->redirect(Yii::app()->user->returnUrl);
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
        Yii::import('application.modules.user.models.User');

        // Пометим, куда возвращаться после редактирования отзывов
        Yii::app()->user->returnUrl=$this->createUrl('index');

		$model=new CatalogReviews('search');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['CatalogReviews']))
			$model->attributes=$_GET['CatalogReviews'];

		$this->render('index',array(
			'model'=>$model,
		));
	}

	/**
	 * Manages all models.
	 */
	public function actionAdmin()
	{
		$model=new CatalogReviews('search');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['CatalogReviews']))
			$model->attributes=$_GET['CatalogReviews'];

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
		$model=CatalogReviews::model()->findByPk($id);
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
		if(isset($_POST['ajax']) && $_POST['ajax']==='catalog-reviews-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
}
