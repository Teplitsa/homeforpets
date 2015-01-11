<?php
/**
 * Controller for manage site menu items
 */
class MenuItemController extends BackEndController
{
	/**
	 * @return array
	 */
	public function actions()
	{
		return array(
			'move' => 'ext.SSortable.SSortableAction',
		);
	}

	/**
	 * Creates a new model.
	 *
	 * @param $menuId
	 * @param int $parentId
	 *
	 * @throws CHttpException
	 */
	public function actionCreate($menuId, $parentId = 0)
	{
		$menu = $this->loadMenuModel($menuId);
		$this->breadcrumbs = MenuItem::getBreadcrumbs($parentId, $menuId, 'Добавление');
		$model = new MenuItem;
		$model->menu_id = $menuId;
		$model->parent_id = $parentId;
		if (isset($_POST['MenuItem']))
		{
			$model->attributes = $_POST['MenuItem'];
			if ($model->save())
				$this->redirect(array('index', 'menuId' => $model->menu_id, 'parentId' => $model->parent_id));
		}

		$this->render('form', array(
			'model' => $model,
			'menu' => $menu,
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
		$this->breadcrumbs = MenuItem::getBreadcrumbs($id, $model->menu_id, 'Редактирование');
		if (isset($_POST['MenuItem']))
		{
			$model->attributes = $_POST['MenuItem'];
			if ($model->save())
				$this->redirect(array('index', 'menuId' => $model->menu_id, 'parentId' => $model->parent_id));
		}
		$this->render('form', array(
			'model' => $model,
			'menu' => $model->menu,
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
			if(!isset($_GET['ajax']))
				$this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('index'));
		}
		else
			throw new CHttpException(400, 'Invalid request. Please do not repeat this request again.');
	}

	/**
	 * Lists all models.
	 */
	public function actionIndex($menuId, $parentId = 0)
	{
		$menu = $this->loadMenuModel($menuId);
		$this->breadcrumbs = MenuItem::getBreadcrumbs($parentId, $menuId);
		$model = new MenuItem('search');
		$model->unsetAttributes();
		$model->menu_id = $menuId;
		$model->parent_id = $parentId;
		if (isset($_GET['MenuItem']))
			$model->attributes = $_GET['MenuItem'];

		$this->render('index', array(
			'model' => $model,
			'menu' => $menu,
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
	 * @return MenuItem
	 */
	public function loadModel($id)
	{
		$model = MenuItem::model()->with('menu')->findByPk($id);
		if ($model === null)
			throw new CHttpException(404, 'The requested page does not exist.');
			
		return $model;
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
	public function loadMenuModel($id)
	{
		$model = Menu::model()->findByPk($id);
		if ($model === null)
			throw new CHttpException(404, 'The requested page does not exist.');
			
		return $model;
	}
}
