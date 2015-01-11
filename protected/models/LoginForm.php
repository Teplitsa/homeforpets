<?php

/**
 * LoginForm class.
 * LoginForm is the data structure for keeping
 * user login form data. It is used by the 'login' action of 'SiteController'.
 */
class LoginForm extends CFormModel
{
    /**
     * @var string
     */
	public $username;

    /**
     * @var string
     */
    public $password;

    /**
     * @var boolean
     */
    public $rememberMe;

    /**
     * @var UserIdentity
     */
    private $_identity;

    /**
     * Declares the validation rules.
     * The rules state that username and password are required,
     * and password needs to be authenticated.
     */
    public function rules()
    {
		return array(
            array('username, password', 'required'),
            array('rememberMe', 'boolean'),
            array('password', 'authenticate'),
        );
    }

    /**
     * Declares attribute labels.
     */
    public function attributeLabels()
    {
		return array(
			'username' => 'Логин',
			'password' => 'Пароль',
            'rememberMe' => 'Запомнить меня',
		);
    }

    /**
     * Authenticates the password.
     * This is the 'authenticate' validator as declared in rules().
     */
    public function authenticate($attribute, $params)
    {
        if (!$this->hasErrors())
        {
			$this->_identity = new UserIdentity($this->username, $this->password);
            if (!$this->_identity->authenticate())
			{
				switch($this->_identity->errorCode)
				{
					case UserIdentity::ERROR_USERNAME_INVALID:
						$this->addError("username", "Пользователь не найден.");
						break;
					case UserIdentity::ERROR_STATUS_NOTACTIVE:
						$this->addError("username", "Пользователь не активирован.");
						break;
					case UserIdentity::ERROR_STATUS_BAN:
						$this->addError("username", "Пользователь заблокирован.");
						break;
					case UserIdentity::ERROR_PASSWORD_INVALID:
						$this->addError("password", "Некорректный пароль.");
						break;
					case UserIdentity::ERROR_ROLE_INVALID:
						$this->addError("username", "Некорректная роль пользователя.");
						break;
				}
			}
        }
    }

    /**
     * Logs in the user using the given username and password in the model.
     * @return boolean whether login is successful
     */
    public function login()
    {
        if ($this->_identity === null)
		{
            $this->_identity = new UserIdentity($this->username, $this->password);
            $this->_identity->authenticate();
        }
        if ($this->_identity->errorCode === UserIdentity::ERROR_NONE)
        {
            $duration = $this->rememberMe ? 3600*24*30 : 0; // 30 days
            Yii::app()->user->login($this->_identity, $duration);
            return true;
        }
        else
            return false;
    }
}