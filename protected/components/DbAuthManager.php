<?php
/**
 * Db authorization manager class
 */
class DbAuthManager extends CDbAuthManager
{
	/**
	 * @var string $userTable Users table name 
	 */
    public $userTable = "user";
	
	/**
	 * Checks access for user
	 * @param string $itemName
	 * @param integer $userId
	 * @return boolean
	 */
	public function checkAccess($itemName, $userId, $params = array())
	{
		$role = $this->db->createCommand()->select("role")->from($this->userTable)->where('id=:id', array(':id' => $userId))->queryScalar();
		return ($role and $role === $itemName);
	}
}
?>