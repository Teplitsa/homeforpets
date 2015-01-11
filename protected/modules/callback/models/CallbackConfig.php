<?php

/**
 * This is the model class for table "callback_config".
 *
 * The followings are the available columns in table 'callback_config':
 * @property string $id
 * @property integer $enabled
 * @property string $type
 * @property string $host
 * @property string $username
 * @property string $password
 * @property string $port
 * @property string $encryption
 * @property string $sender
 */
class CallbackConfig extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'callback_config';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		return array(
			array('enabled', 'numerical', 'integerOnly' => true),
			array('type, host, username, password, port, encryption, sender', 'length', 'max' => 255),
			array('enabled, type, host, username, password, port, encryption, sender', 'safe'),
			array('type', 'checkType'),
		);
	}

	/**
	 * @return array relational rules.
	 */
	public function relations()
	{
		return array();
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'enabled' => 'Разрешить отправку писем',
			'type' => 'Тип транспорта',
			'host' => 'Адрес почтового сервера',
			'username' => 'Логин',
			'password' => 'Пароль',
			'port' => 'Порт',
			'encryption' => 'Шифрование',
			'sender' => 'Имя отправителя',
		);
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return CallbackConfig the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

	/**
	 * @return array
	 */
	public function getTransportTypes()
	{
		return array(
			'php' => 'php',
			'smtp' => 'smtp',
		);
	}

	/**
	 * @return array
	 */
	public function getEncryptions()
	{
		return array(
			'ssl' => 'ssl',
			'tls' => 'tls',
		);
	}

	/**
	 * Checks the transport type.
	 * This is the 'checkType' validator as declared in rules().
	 */
	public function checkType($attribute, $params)
	{
		if ($this->type == 'smtp')
		{
			$requireValidator = CValidator::createValidator('required', $this, 'host, username, password');
			$requireValidator->validate($this);
			$emailValidator = CValidator::createValidator('email', $this, 'username');
			$emailValidator->validate($this);
		}
	}
}
