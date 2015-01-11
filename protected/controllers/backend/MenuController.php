<?php
/**
 * Controller for manage site menus
 */
class MenuController extends BackEndController
{
	/**
	 * Creates a new model.
	 */
	public function actionCreate()
	{
		$model = new Menu;
		if (isset($_POST['Menu']))
		{
			$model->attributes = $_POST['Menu'];
			if ($model->save())
				$this->redirect(array('index'));
		}

		$this->render('create',array(
			'model' => $model,
		));
	}

	/**
	 * Updates a particular model.
	 *
	 * @param integer $id the ID of the model to be updated
	 */
	public function actionUpdate($id)
	{
		$model = $this->loadModel($id);
		if (isset($_POST['Menu']))
		{
			$model->attributes = $_POST['Menu'];
			if ($model->save())
				$this->redirect(array('index'));
		}

		$this->render('update',array(
			'model' => $model,
		));
	}

	/**
	 * Deletes a particular model.
	 * If deletion is successful, the browser will be redirected to the 'admin' page.
	 *
	 * @param integer $id the ID of the model to be deleted
	 *
	 * @throws CHttpException
	 */
	public function actionDelete($id)
	{
		if (Yii::app()->request->isPostRequest)
		{
			$this->loadModel($id)->delete();
			// if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
			if (!isset($_GET['ajax']))
				$this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('index'));
		}
		else
			throw new CHttpException(400, 'Invalid request. Please do not repeat this request again.');
	}

	/**
	 * Lists all models.
	 */
	public function actionIndex()
	{
		$model = new Menu('search');
		$model->unsetAttributes();
		if (isset($_GET['Menu']))
			$model->attributes = $_GET['Menu'];

		$this->render('index',array(
			'model' => $model,
		));
	}

	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 *
	 * @param integer $id the ID of the model to be loaded
	 *
	 * @throws CHttpException
	 *
	 * @return Menu
	 */
	public function loadModel($id)
	{
		$model = Menu::model()->findByPk($id);
		if ($model === null)
			throw new CHttpException(404, 'The requested page does not exist.');

		return $model;
	}
}
