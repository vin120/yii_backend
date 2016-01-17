<?php 
/**
 * Controller is the customized base controller class.
 * All controller classes for this application should extend from this base class.
 */
 class Controller extends CController
 {
 	/**
	 * @var string the default layout for the controller view. Defaults to '//layouts/column1',
	 * meaning using a single column layout. See 'protected/views/layouts/column1.php'.
	 */
 	public $layouts = '//layouts/column1';
 	/**
	 * @var array context menu items. This property will be assigned to {@link CMenu::items}.
	 */
 	public $menu = array();
 	/**
	 * @var array the breadcrumbs of the current page. The value of this property will
	 * be assigned to {@link CBreadcrumbs::links}. Please refer to {@link CBreadcrumbs::links}
	 * for more details on how to specify this property.
	 */
 	public $breadcrumbs = array();
 	/**
     *  user defined attribute
     *  each page of the identifier,defalue value 'index'
     *  @var string 
     */
 	public $pageTag = 'index';
 	public $auth;

 	private function setmyaction()
 	{
 		$admin_id = Yii::app()->user->id;
 		$sql = "SELECT b.permission_menu FROM vcos_admin a,vcos_admin_role b WHERE b.role_id = a.role_id AND a.admin_id = {$admin_id} ";
 		$permission = Yii::app()->m_db->createCommand($sql)->queryRow();
 		if($permission['permission_menu'] != '0')
 		{
 			//decode json data as array()
 			$permission = json_decode($permission['permission_menu'],true);
 			$auth = array();
 			foreach($permission as $key=>$row)
 			{
 				$auth[] = $key;
 				foreach($row as $k=>$val)
 				{
 					if(is_array($val))
 					{
 						$auth[] = $k;
 						foreach($val as $item)
 						{
 							$auth[] = $item;			
 						}
 					}
 					else
 					{
 						$auth[] = $val;
 					}
 				}
 			}
 		}
 		else
 		{
 			$auth[0] = $permission['permission_menu'];
 		}
 		return $auth;
 	}

 	private function getmethod_id()
 	{
 		$name = $this->getAction()->getId(); 	//get name of action 
 		$sql = "SELECT menu_id FROM vcos_permission_menux WHERE method_name = '{$name}'" ;
 		$method_id = Yii::app()->m_db->createCommand($sql)->queryRow();
 		return $method_id['menu_id'];
 	}

 	public function setauth()
 	{
 		if(in_array($this->getmethod_id(), $this->auth) || $this->auth[0] == '0')
 		{

 		}
 		else
 		{
 			$error = Yii::app()->createUrl('error/index');
 			$this->redirect($error);
 		}
 	}

 	public function actionChecklsbooking()
    {
        $result = VcosLifeserviceBooking::model()->count("is_read=:num",array(':num'=>'0'));
        echo $result;
    }

 	public function actionCheckgoodsorder()
 	{
 		$result = VcosGoodsOrder::model()->count("is_read=:num",array(':num'=>'0'));
 		echo $result;
 	}

 	public function init()
 	{
 		MyLanguage::setLanguage();
 		if(empty(Yii::app()->user->id))
 		{
 			if(!stripos(Yii::app()->request->getUrl(),'login'))
 			{
 				$this->redirect(Yii::app()->createUrl('login/login'));
 			}
 		}
 		else
 		{
 			$admin_id = Yii::app()->user->id;
 			$sql = "SELECT * FROM vcos_admin WHERE admin_id = '{$admin_id}'";
 			$result = Yii::app()->m_db->createCommand($sql)->queryRow();
 			if(!$result)
 			{
 				Yii::app()->session->clear();
 				Yii::app()->session->destroy();
 				die(Helper::show_message(Yii::t('vcos','你的账户已经被删除了'),Yii::app()->createUrl("login/login")));
 			}
 		}
 		$this->auth = $this->setmyaction();
 	}

 }