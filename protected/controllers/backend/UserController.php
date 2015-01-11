<?php

class UserController extends BackEndController
{
	public function actionChangePassword($id = null)
	{
		if ($id === null)
			$id = Yii::app()->user->id;
			
		$model = $this->loadModel($id);
		$model->setScenario('changepassword');
		$oldPassword = $model->password;
		if (isset($_POST['User']))
		{
			$model->attributes = $_POST['User'];
			if ($model->save())
				Yii::app()->user->setFlash('success', "Пароль успешно изменен!");
		}
		
		$this->render('changepassword', array(
			'model' => $model
		));
	}
	
	public function actionChangeEmail($id = null)
	{
		if ($id === null)
			$id = Yii::app()->user->id;
			
		$model = $this->loadModel($id);
		$model->setScenario('changeemail');
		if (isset($_POST['User']))
		{
			$model->attributes = $_POST['User'];
			if ($model->save())
				Yii::app()->user->setFlash('success', "Email успешно изменен!");
		}
		
		$this->render('changeemail', array(
			'model' => $model
		));
	}
	
	/**
	 * Returns the data model of user
	 */
	public function loadModel($id)
	{
		$model = User::model()->findbyPk($id);
		if ($model === null)
			throw new CHttpException(404, 'The requested page does not exist.');
			
		return $model;
	}
}
?>