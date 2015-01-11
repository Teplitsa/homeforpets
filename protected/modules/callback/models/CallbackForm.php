<?php

/**
 * Class CallbackForm
 */
class CallbackForm extends CFormModel
{
	/**
	 * @var string
	 */
	public $name;

	/**
	 * @var string
	 */
	public $email;

	/**
	 * @var string
	 */
	public $text;

	/**
	 * @var string
	 */
	public $verifyCode;

	/**
	 * Declares the validation rules.
	 */
	public function rules()
	{
		return array(
			array('name, text, email', 'required'),
            array('email', 'email'),
			/*array(
                'verifyCode',
                'captcha',
                'message' => 'Неверный защитный код',
                // авторизованным пользователям код можно не вводить
                'allowEmpty' => !Yii::app()->user->isGuest || !extension_loaded('gd')
            ),*/
		);
	}

	/**
	 * Declares customized attribute labels.
	 * If not declared here, an attribute would have a label that is
	 * the same as its name with the first letter in upper case.
	 */
	public function attributeLabels()
	{
		return array(
			'name' => 'Ваше имя',
			'email' => 'Ваш e-mail',
			'text' => 'Текст сообщения',
			'file' => 'Прикрепить файл',
			'verifyCode' => 'Введите код',
		);
	}
}