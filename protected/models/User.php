<?php

/**
 * This is the model class for table "user".
 *
 * The followings are the available columns in table 'user':
 * @property integer $id
 * @property string $username
 * @property string $email
 * @property string $password
 * @property string $salt
 * @property string $role
 * @property integer $status
 */
class User extends CActiveRecord
{
	/**
	 * $var string $newPassword
	 */
	public $newPassword;
	
	/**
	 * $var string $confirmNewPassword
	 */
	public $confirmNewPassword;
	
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return User the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'user';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		return array(
			array('username, email, password, role', 'required', 'except' => 'changepassword, changeemail'),
			array('status', 'numerical', 'integerOnly' => true),
			array('username, email, password, salt, role', 'length', 'max' => 255),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, username, email, password, salt, role, status', 'safe', 'on' => 'search'),
			array('newPassword', 'compare', 'compareAttribute' => 'confirmNewPassword'),
			array('confirmNewPassword', 'safe'),
			array('newPassword', 'setNewPassword'),
			array('email', 'email', 'message' => 'Неверный адрес электронной почты.', 'on' => 'changeemail'),
		);
	}

	/**
	 * @return array relational rules.
	 */
	public function relations()
	{
		return array(
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'username' => 'Username',
			'email' => 'Email-адрес',
			'password' => 'Password',
			'salt' => 'Salt',
			'role' => 'Role',
			'status' => 'Status',
			'newPassword' => 'Новый Пароль',
			'confirmNewPassword' => 'Повторите Пароль',
		);
	}

	/**
	 * Retrieves a list of models based on the current search/filter conditions.
	 * @return CActiveDataProvider the data provider that can return the models based on the search/filter conditions.
	 */
	public function search()
	{
		$criteria=new CDbCriteria;

		$criteria->compare('id',$this->id);
		$criteria->compare('username',$this->username,true);
		$criteria->compare('email',$this->email,true);
		$criteria->compare('password',$this->password,true);
		$criteria->compare('salt',$this->salt,true);
		$criteria->compare('role',$this->role,true);
		$criteria->compare('status',$this->status);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
	
	/**
	 * Generates password hash
	 * @var string $password
	 * @var string $salt
	 * @return string
	 */
	public function hashPassword($password, $salt)
	{
		return md5($salt . $password);
	}
		
	/**
	 * Validates password
	 * @var string $password
	 * @return boolean
	 */
	public function validatePassword($password)
    {
		return $this->hashPassword($password, $this->salt) === $this->password;
	}

	/**
	 * Validator for new password
	 */
    function setNewPassword($attribute, $params)
    {
		if (!empty($this->newPassword)) 
		{
			$this->generateSalt();
            $this->password = $this->hashPassword($this->newPassword, $this->salt);
        }
	}

    /**
     * Generates a salt that can be used to generate a password hash.
     * @return string the salt
     */
    protected function generateSalt()
    {
		$this->salt = uniqid('', true);
    }
	
	/**
	 * Validates role
	 * @var string $role
	 * @return boolean
	 */
	public function validateRole($role)
	{
		return $role === "admin";
	}
}