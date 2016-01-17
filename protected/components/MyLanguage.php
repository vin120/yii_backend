<?php  

class MyLanguage
{
	public static function setLanguage()
	{
		//set language from $_GET function
		$cookies = Yii::app()->request->getCookies();
		if(isset($_GET['lang'])&& $_GET['lang'] != "")
		{
			Yii::app()->language = $_GET['lang'];
			$cookies = new CHttpCookie('my_language',$_GET['lang']);
			$cookies->expire = time() + 60 * 60 * 6;
			Yii::app()->request->cookies['my_language'] = $cookies;
		}
		//set language from cookies
		elseif(isset($cookies['my_language']) && $cookies['my_language'] !="")
		{
			$temp_lang = $cookies['my_language']->value;
			Yii::app()->language = $temp_lang;
		}
		//set language from browse
		else
		{
			$lang = explode(',', $_SERVER['HTTP_ACCEPT_LANGUAGE']);
			Yii::app()->language = strtolower(str_replace('-','_',$lang[0]));
		}
	}
}