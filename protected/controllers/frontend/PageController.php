<?php

/**
 * Class PageController
 * Frontend site page manage
 */
class PageController extends FrontEndController
{
	/**
	 * Views site page
	 *
	 * @param $id
	 *
	 * @throws CHttpException
	 */
	public function actionView($id)
	{
       	$model = $this->loadModel($id);
		$this->breadcrumbs = $model->getFrontBreadcrumbs();
		$this->metaInfoGenerate($model->title, $model->keywords, $model->description);
		if ($model->layout)
			$this->layout = $model->layout;

        if ($model->view)
			$view = $model->view;
		else
			$view = 'view';

		$this->render($view, array(
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
