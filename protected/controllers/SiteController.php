<?php

class SiteController extends Controller
{
	private $_member_id;
	public $wifi_server_conf_array;

	/**
	 * Declares class-based actions.
	 */
	public function actions()
	{
		return array(
			// captcha action renders the CAPTCHA image displayed on the contact page
			'captcha'=>array(
				'class'=>'CCaptchaAction',
				'backColor'=>0xFFFFFF,
			),
			// page action renders "static" pages stored under 'protected/views/site/pages'
			// They can be accessed via: index.php?r=site/page&view=FileName
			'page'=>array(
				'class'=>'CViewAction',
			),
		);
	}

	/**
	 * This is the default 'index' action that is invoked
	 * when an action is not explicitly requested by users.
	 */
	public function actionIndex()
	{
		// renders the view file 'protected/views/site/index.php'
		// using the default layout 'protected/views/layouts/main.php'
		$this->render('index');
	}

	public function actionMembership()
	{
		$membership = Membership::model()->findByPk(Yii::app()->user->id);
		$this->render('membership',array('membership'=>$_member_id));
	}

	// change password
	public function actionUpdatepasswd()
	{
		if(isset($_POST['password']) && isset($_POST['password2']) && ($_POST['password'] == $_POST['password2']))
		{
			$membership = Membership::model()->findByPk($this->member_id);
			$membership->member_password = md5($_POST['password']);
			$membership->save();
			$this->redirect(array('site/message','message_info'=>'密码修改成功','menu_type'=>'membership_safe'));
		}
		$this->render('update_passwd');
	}


	public function actionMessage()
	{
		$message_info = isset($_GET['message_info']) ? $_GET['message_info'] : '';
		$menu_type = isset($_GET['menu_type']) ? $_GET['menu_type'] : '';
		$res_action = isset($_GET['res_action']) ? $_GET['res_action'] : '';

		$this->render('message_view',array('message_info'=>$message_info,'menu_type'=>$menu_type,'res_action'=>$res_action));
	}

	public function actionNewsdiscount()
	{
		$this->render('news_discount_view');
	}

	public function actionMembershipcredit()
	{
		$this->render('membership_credit_view');
	}

	public function actionMembershipcosts()
	{
		$this->render('membership_costs_view');
	}


	/**
	 * This is the action to handle external exceptions.
	 */
	public function actionError()
	{
	    if($error=Yii::app()->errorHandler->error)
	    {
	    	if(Yii::app()->request->isAjaxRequest)
	    		echo $error['message'];
	    	else
	        	$this->render('error', $error);
	    }
	}

	/**
	 * Logs out the current user and redirect to homepage.
	 */
	public function actionLogout()
	{
        Yii::app()->user->logout();
        Yii::app()->session->clear();
        Yii::app()->session->destroy();
        $this->redirect(Yii::app()->homeUrl);
	}


	/*
	 *  验证用户输入密码，密码正确可以删除
	 *
	 */
	
	public function actionCheckUserPass()
	{
		$p_db = Yii::app()->m_db;
		$pass = isset($_GET['pass']) ? $_GET['pass'] : '';
		$this_user_id = Yii::app()->user->id;
		$res = 0;
		$sql = "SELECT admin_password FROM `vcos_admin` WHERE admin_id = '{$this_user_id}' LIMIT 1 " ;
		$result = $p_db->createCommand($sql)->queryRow();
		if($this_user_id == 1)
		{
			//super_admin
			if($result['admin_password'] == md5($pass) || $result['admin_password'] == $pass)
			{
				$res = 1;
			}
		}
		else
		{
			if($result['admin_password'] == md5($pass))
			{
				$res = 1;
			}
		}
		echo $res;
	}
}