<?php

/**
 * Class SiteController
 * Main front site controller
 */
class SiteController extends FrontEndController
{
	/**
	 * Declares class-based actions.
	 *
	 * @return array
	 */
	public function actions()
	{
		return array(
			// captcha action renders the CAPTCHA image displayed on the contact page
			'captcha'=>array(
				'class'=>'CCaptchaAction',
				'backColor'=>0xFFFFFF,
			),
		);
	}

	/**
	 * This is the default 'index' action that is invoked
	 * when an action is not explicitly requested by users.
	 *
	 * @throws CHttpException
	 */
	public function actionIndex()
	{
		$model = Page::model()->findbyPk(Yii::app()->config->mainpage_id);
		if ($model === null)
			throw new CHttpException(404, 'Страницы с id = '.Yii::app()->config->mainpage_id.' не существует! Укажите в конфигурации сайта правильный id главной страницы.');

		$this->metaInfoGenerate($model->title, $model->keywords, $model->description);
		if ($model->layout)
			$this->layout = $model->layout;

		$this->render('index', array(
			'model' => $model,
		));
	}

	/**
	 * This is the action to handle external exceptions.
	 */
	public function actionError()
	{
	    if ($error = Yii::app()->errorHandler->error)
	    {
	    	if (Yii::app()->request->isAjaxRequest)
	    		echo $error['message'];
	    	else
	        	$this->render('error', $error);
	    }
	}

	/**
	 * Redirects to site manager
	 */
	public function actionLogin()
	{
		$this->redirect('/manage');
	}

	/**
	 * Logs out the current user and redirect to homepage.
	 */
	public function actionLogout()
	{
		Yii::app()->user->logout();
		$this->redirect(Yii::app()->homeUrl);
	}

	/**
	 * Site in development message
	 */
    public function actionCap()
	{
        $this->layout='cap';
        $this->render('cap');
    }
}