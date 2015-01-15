<?php

class ReviewsController extends FrontEndController
{

	public function actions()
	{
		return (isset($_POST['ajax']) && $_POST['ajax']==='registration-form')?array():array(
			'captcha'=>array(
				'class'=>'CCaptchaAction',
				'backColor'=>0xFFFFFF,
			),
		);
	}
    
	/**
	 * Creates a new model.
	 * If creation is successful, the browser will be redirected to the 'view' page.
	 */
	public function actionCreate($product_id)
	{
        if(!Yii::app()->user->isGuest){

            if($product=CatalogProduct::model()->findByPk($product_id)){

                $model=new CatalogReviews;

                // Uncomment the following line if AJAX validation is needed
                // $this->performAjaxValidation($model);

                if(isset($_POST['CatalogReviews']))
                {

                    $model->attributes=$_POST['CatalogReviews'];
                    $model->product_id=$product->id;
                    $model->published=0;
                    if($model->save()){
                        $this->render('success',array(
                            'model'=>$model,
                        ));
                    }else{
                        $this->render('create',array(
                            'model'=>$model,
                        ));
                    }

                }else{
                    $this->render('create',array(
                        'model'=>$model,
                    ));
                }
            } else
			    throw new CHttpException(400,'Попытка добавить отзыв к несуществующему товару!');

        } else {
            $this->render('noautorized');
        }
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

		if(isset($_POST['CatalogReviews']))
		{
			$model->attributes=$_POST['CatalogReviews'];
			if($model->save())
				$this->redirect(array('view','id'=>$model->id));
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
		$model=new CatalogReviews('search');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['CatalogReviews']))
			$model->attributes=$_GET['CatalogReviews'];

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
