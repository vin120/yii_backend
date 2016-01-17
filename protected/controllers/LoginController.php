<?php 

class LoginController extends CLoginController
{
	/*
	 * Displays the login page .
	 */
	public function actionLogin()
	{
		$this->layout = false;

		if(!empty(Yii::app()->user->id))
		{
			$this->redirect(Yii::app()->createUrl('site/index'));
		}

		$reffer_url = isset($_SERVER['HTTP_REFERER']) ? $_SERVER['HTTP_REFERER'] : '';
		$server_name = isset($_SERVER['SERVER_NAME']) ? $_SERVER['SERVER_NAME'] : '' ;
		if(stripos('prefix'.$reffer_url, $server_name) && !stripos($reffer_url, 'login'))
		{
			$cookie = new CHttpCookie('my_reffer_url',$reffer_url);
			$cookie->expire = time() + 60 * 60;
			Yii::app()->request->cookies['my_reffer_url'] = $cookie;
		}

		$model = new MyLoginForm;
		if(isset($_POST['username']) && isset($_POST['password']))
		{
			$model->username = $_POST['username'];
			$model->password = $_POST['password'];
			$model->rememberMe = empty($_POST['rememberMe']) ? false : true;

			//validate user input and redirect to the previous page if valid 
			if($model->validate() && $model->login())
			{
				$cookie = Yii::app()->request->getCookies();
				$admin = VcosAdmin::model()->findByPk(Yii::app()->user->id);
				$admin->last_login_ip = Helper::getIp();
				$admin->last_login_time = date('Y-m-d H:i:s',time());

				if($admin->save())
				{
					if(isset($cookie['my_reffer_url']) && !empty($cookie['my_reffer_url']))
					{
						$my_reffer_url = $cookie['my_reffer_url']->value;
						$this->redirect($my_reffer_url);
					}
					else
					{
						$this->redirect(Yii::app()->createUrl('site/index'));
					}
				}
			}
			else
			{
				$this->render('login',array('model'=>$model,'login_state'=>true));
				exit;
			}
		}
		//display the login form
		$this->render('login',array('model'=>$model));
	}
}