<?php

/**
 * Class AreaController
 * Manage site areas
 */
class AreaController extends BackEndController
{
	/**
	 * Lists all models.
	 */
	public function actionIndex()
	{
		$dataProvider = new CActiveDataProvider('Area');
		$this->render('index',array(
			'dataProvider' => $dataProvider,
		));
	}

	/**
	 * Creates a new model.
	 */
	public function actionCreate()
	{
		$model = new Area;
		if (isset($_POST['Area']))
		{
			$model->attributes = $_POST['Area'];
			if ($model->save())
				$this->redirect(array('index'));
		}

		$this->render('create', array(
			'model' => $model,
		));
	}

	/**
	 * Updates a particular model.
	 *
	 * @param integer $id the ID of the model to be updated
	 *
	 * @throws CHttpException
	 */
	public function actionUpdate($id)
	{
		$model = $this->loadModel($id);
		if (isset($_POST['Area']))
		{
			$model->attributes = $_POST['Area'];
			if ($model->save())
				$this->redirect(array('index'));
		}

		$this->render('update', array(
			'model' => $model,
		));
	}

	/**
	 * Deletes a particular model.
	 * If deletion is successful, the browser will be redirected to the 'admin' page.
	 *
	 * @param integer $id the ID of the model to be deleted
	 *
	 * @throws CDbException
	 * @throws CHttpException
	 */
	public function actionDelete($id)
	{
		if (Yii::app()->request->isPostRequest)
		{
			$model = $this->loadModel($id);
			if (!$model->blocks)
				$model->delete();

			// if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
			if (!isset($_GET['ajax']))
				$this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('admin'));
		}
		else
			throw new CHttpException(400, 'Invalid request. Please do not repeat this request again.');
	}

	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 *
	 * @param integer $id the ID of the model to be loaded
	 *
	 * @throws CHttpException
	 * 
	 * @return Area
	 */
	public function loadModel($id)
	{
		$model = Area::model()->findByPk($id);
		if ($model === null)
			throw new CHttpException(404, 'The requested page does not exist.');

		return $model;
	}
}
