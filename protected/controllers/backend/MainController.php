<?php
/**
 * Main backend controller
 */
class MainController extends BackEndController
{
	/**
	 * List of access rules
	 */
	public function accessRules()
    {
        return array(
			array('allow',
				'roles' => array('admin'),
            ),
			array('allow',
				'actions' => array('error', 'login', 'logout'),
                'users' => array('*'),
			),
            array('deny',
				'users' => array('*'),
			),
        );
    }

	/**
	 * Default controller action
	 */
	public function actionIndex()
	{
		$this->render('index');
	}

	/**
	 * Backend error action
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
	 * Backend login action
	 */
	public function actionLogin()
	{
		$model = new LoginForm;
		if (isset($_POST['LoginForm']))
		{
			$model->attributes = $_POST['LoginForm'];
			if ($model->validate() and $model->login())
				$this->redirect(Yii::app()->user->returnUrl);
		}
		$this->layout = "login";
		$this->render('login', array('model' => $model));
	}

	/**
	 * Backend logout action
	 */
	public function actionLogout()
	{
		$returnUrl = Yii::app()->user->returnUrl;
		Yii::app()->user->logout();
		$this->redirect($returnUrl);
	}
}