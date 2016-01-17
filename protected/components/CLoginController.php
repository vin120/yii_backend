<?php 

/**
 * CLoginController is the customized base controller class.
 * All controller classes for this application should extend from this base class.
 */
class CLoginController extends CController
{
	/**
	 * @var string the default layout for the controller view. Defaults to '//layouts/column1',
	 * meaning using a single column layout. See 'protected/views/layouts/column1.php'.
	 */
	public $layout = '//layouts/column1';
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

	public function init()
	{
		//set language
		MyLanguage::setLanguage();
		//if not stay in the 'login' page ,redirect to 'login' page
		if(empty(Yii::app()->user->id))
		{
			if(!stripos(Yii::app()->request->getUrl(),'login'))
			{
				$this->redirect(Yii::app()->createUrl('login/login'));
			}
		}
	}
}