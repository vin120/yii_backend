<?php 

/**
 * UserIdentity represents the data needed to identity a user.
 * It contains the authentication method that checks if the provided
 * data can identity the user.
 */

 class UserIdentity extends CUserIdentity
 {
 	public $id;
 	public $e_mail;
 	public $cn_name;

 	/**
	 * Authenticates a user.
	 * The example implementation makes sure if the username and password
	 * are both 'demo'.
	 * In practical applications, this should be changed to authenticate
	 * against some persistent user identity storage (e.g. database).
	 * @return boolean whether authentication succeeds.
	 */

 	public function authenticate()
 	{
 		$where_name = 'admin_name = \''.$this->username.'\'';
 		$sql_value = 'SELECT * FROM `vcos_admin` WHERE '.$where_name.'  LIMIT 1';
 		$admin = Yii::app()->m_db->createCommand($sql_value)->queryRow();
 		$admin_password = $admin['admin_password'];
 		$admin_state = $admin['admin_state'];
 		$login_state_bool = false;
 		if($admin_state)
 		{
 			if('888888' == $admin_password && $this->password == $admin_password)
 			{
 				$login_state_bool = true;
 			}
 			elseif(md5($this->password) == $admin_password)
 			{
 				$login_state_bool = true;
 			}
 		}

 		if(!$login_state_bool)
 		{
 			$this->errorCode = self::ERROR_PASSWORD_INVALID;
 		}
 		else
 		{
 			$this->id = $admin['admin_id'];
 			$this->cn_name = $admin['admin_real_name'];
 			$this->e_mail = $admin['admin_email'];
 			$this->errorCode = self::ERROR_NONE;
 		}
 		return !$this->errorCode;
 	}

 	public function getName()
 	{
 		return $this->cn_name;
 	}

 	public function getId()
 	{
 		return $this->id;
 	}

 	public function getEmail()
 	{
 		return $this->e_mail;
 	}
 }