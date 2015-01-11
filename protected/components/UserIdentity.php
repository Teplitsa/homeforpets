<?php

/**
 * UserIdentity represents the data needed to identity a user.
 * It contains the authentication method that checks if the provided
 * data can identity the user.
 */
class UserIdentity extends CUserIdentity
{
	const ERROR_STATUS_NOTACTIVE = 4;
	const ERROR_STATUS_BAN = 5;
	const ERROR_ROLE_INVALID = 6;

    public function authenticate()
    {
        $username = strtolower($this->username);
		$user = User::model()->find('LOWER(username)=?',array($username));
        if ($user === null)
            $this->errorCode = self::ERROR_USERNAME_INVALID;
        elseif (!$user->validatePassword($this->password))
            $this->errorCode = self::ERROR_PASSWORD_INVALID;
		elseif ($user->status == 0)
			$this->errorCode = self::ERROR_STATUS_NOTACTIVE;
		elseif ($user->status == -1)
			$this->errorCode = self::ERROR_STATUS_BAN;
		elseif (!$user->validateRole($user->role))
			$this->errorCode = self::ERROR_ROLE_INVALID;
        else
        {
			$this->setState('__id', $user->id);
			$this->setState('__name', $username);
            $this->errorCode = self::ERROR_NONE;
        }
        return $this->errorCode == self::ERROR_NONE;
    }
}