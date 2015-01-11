<?php
/**
 * Backend Controller for manage site pages
 */
class PageController extends BackEndController
{
	/**
	 * Lists all pages
	 *
	 * @param int $parentId
	 */
	public function actionIndex($parentId = 0)
	{
		$model = new Page('search');
		$this->breadcrumbs = Page::getBreadcrumbs($parentId);
		$model->unsetAttributes();
		$model->parent_id = $parentId;
		if (isset($_GET['Page']))
			$model->attributes = $_GET['Page'];

		$this->render('index', array(
			'model' => $model,
			'parentId' => $parentId,
		));
	}

	/**
	 * Creates a new model.
	 *
	 * @param integer $parentId
	 */
	public function actionCreate($parentId)
	{
		$model = new Page;
		$model->parent_id = $parentId + 0;
		$model->layout = 'main';
		$model->view = 'view';
		$this->breadcrumbs = Page::getBreadcrumbs($parentId, 'Добавление');
		if (isset($_POST['Page']))
		{
			$model->attributes = $_POST['Page'];
			if ($model->save())
				$this->redirect(array('index', 'parentId' => $model->parent_id));
		}

		$this->render('form', array(
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
		$this->breadcrumbs = Page::getBreadcrumbs($model->id, 'Редактирование');
		if (isset($_POST['Page']))
		{
			$model->attributes = $_POST['Page'];
			if ($model->save())
				$this->redirect(array('index', 'parentId' => $model->parent_id));
		}

		$this->render('form',array(
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
			$model = $this->loadModel($id);
			if (!$model->childs)
			{
				$model->delete();
				if (!isset($_GET['ajax']))
					$this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('index', 'parentId' => $model->parent_id));
			}
			else
				throw new CHttpException(400, 'Невозможно удалить страницу с подстраницами.');
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
	 * @return Page
	 */
	public function loadModel($id)
	{
		$model = Page::model()->findByPk($id);
		if ($model === null)
			throw new CHttpException(404, 'The requested page does not exist.');

		return $model;
	}
}
