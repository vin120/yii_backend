<?php 

class WebUser extends CWebUser
{
	//Store model to not repeat query.
	private $_model;

	//Return firest_name.
	function getFirstName()
	{
		$user = $this->loadUser(Yii::app()->user->id);
		return $user->first_name;
	}

	//This is a function that checks the field 'role'
	//in the User model to be equal to 1,that means it is admin
	function isAdmin()
	{
		$user = $this->loadUser(Yii::app()->user->id);
		if($user === null)
		{
			return 0;
		}
		else 
			return $user->role == "管理员";
	}

	protected function loadUser($id = null)
	{
		if($this->_model === null)
		{
			if($id !== null)
			{
				$this->_model = User::model()->findByPk($id);
			}
		}
		return $this->_model;
	}

}