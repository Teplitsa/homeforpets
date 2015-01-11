<?php

/**
 * Class CallbackModule
 */
class CallbackModule extends CWebModule
{
	/**
	 * Module init
	 */
	public function init()
	{
		$this->setImport(array(
			'callback.models.*',
			'callback.components.*',
		));
		$this->controllerPath = $this->getControllerPath() . DIRECTORY_SEPARATOR . Yii::app()->branch;
		$this->viewPath = $this->getViewPath() . DIRECTORY_SEPARATOR . Yii::app()->branch;
	}

	/**
	 * @param CController $controller
	 * @param CAction $action
	 * @return bool
	 */
	public function beforeControllerAction($controller, $action)
	{
		if (parent::beforeControllerAction($controller, $action))
		{
			return true;
		}
		else
			return false;
	}

	/**
	 * Sends a message
	 *
	 * @param $to
	 * @param $subject
	 * @param $body
	 *
	 * @return int
	 */
	public function sendMessage($to, $subject, $body)
	{
		$mailer = new CallbackMail();
		return $mailer->send($to, $subject, $body);
	}
}
