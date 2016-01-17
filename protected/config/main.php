<?php

// uncomment the following to define a path alias
// Yii::setPathOfAlias('local','path/to/local-folder');

// This is the main Web application configuration. Any writable
// CWebApplication properties can be configured here.
return array(
	'basePath'=>dirname(__FILE__).DIRECTORY_SEPARATOR.'..',
	'name'=>'Guest service system',
	'language'=>'zh_cn',
	//'timeZone'=>'etc/gmt-8',
	'theme'=>'ace',
	'defaultController'=>'login/login',

	// preloading 'log' component
	'preload'=>array('log'),

	// autoloading model and component classes
	'import'=>array(
		'application.models.*',
		'application.components.*',
		'application.widget.*',
		'application.service.*',
	),

	'modules'=>array(
		// uncomment the following to enable the Gii tool
		
		'gii'=>array(
			'class'=>'system.gii.GiiModule',
			'password'=>'123456',
		 	// If removed, Gii defaults to localhost only. Edit carefully to taste.
			'ipFilters'=>array('127.0.0.1','::1'),
		),
		
	),

	// application components
	'components'=>array(
		'user'=>array(
			// enable cookie-based authentication
			'allowAutoLogin'=>true,
		),
		'cache'=>array(
			'class'=>'system.caching.CFileCache'
		),
		// uncomment the following to enable URLs in path-format
		
		'urlManager'=>array(
			'urlFormat'=>'path',
			'showScriptName'=>false,
			'rules'=>array(
				'login/login/'=> array(
					'login/login/','urlSuffix'=>'.html','caseSensitive'=>false
				),
				'wifiportal/index/'=>array(
					'wifiportal/index/','urlSuffix'=>'.html','caseSensitive'=>false
				),
				// '<controller:\w+>/<id:\d+>'=>'<controller>/view',
				// '<controller:\w+>/<action:\w+>/<id:\d+>'=>'<controller>/<action>',
				// '<controller:\w+>/<action:\w+>'=>'<controller>/<action>',
			),
		),
		
		// 'db'=>array(
		// 	'connectionString' => 'sqlite:'.dirname(__FILE__).'/../data/testdrive.db',
		// ),
		// uncomment the following to use a MySQL database
		
		'db'=>array(
			'class'=>'CDbConnection',
			'connectionString' => 'mysql:host=localhost;dbname=test_mobile',
			'emulatePrepare' => true,
			'username' => 'root',
			'password' => '123456',
			'charset' => 'utf8',
		),
		'm_db'=>array(
			'class'=>'CDbConnection',
			'connectionString' => 'mysql:host=localhost;dbname=test_mobile',
			'emulatePrepare' => true,
			'username' => 'root',
			'password' => '123456',
			'charset' => 'utf8',
		),
		'p_db'=>array(
			'class'=>'CDbConnection',
			'connectionString' => 'mysql:host=localhost;dbname=vcos_product',
			'emulatePrepare' => true,
			'username' => 'root',
			'password' => '123456',
			'charset' => 'utf8',
		),


		'session'=>array(
			'autoStart'=>false,
			'cookieParams'=>array('domain'=>'','lifetime'=>21600,'path'=>'/'),
			'cookieMode'=>'allow',
			'timeout'=>21600,
		),

	
		'errorHandler'=>array(
			// use 'site/error' action to display errors
            'errorAction'=>'site/error',
        ),
		'log'=>array(
			'class'=>'CLogRouter',
			'routes'=>array(
				array(
					'class'=>'CFileLogRoute',
					'levels'=>'error, warning',
				),
				// uncomment the following to show log messages on web pages
				/*
				array(
					'class'=>'CWebLogRoute',
				),
				*/
			),
		),
	),

	// application-level parameters that can be accessed
	// using Yii::app()->params['paramName']
	'params'=>array(
		// this is used in contact page
		'adminEmail'=>'webmaster@example.com',
	),

	// application-level parameters that can be accessed
	// using Yii::app()->params['paramName']
	
	/*
	 * 编辑器配置图片路径
	 * @img_ueditor_old_js 编辑页面外语替换，将ueditor->http://www.wap.com/ueditor
	 * @img_ueditor_old 编辑页面中文替换，将ueditor->http://www.wap.com/ueditor
	 * @img_ueditor_php 入库替换 将http://www.wap.com -> ''
	 * @img_ueditor 用于 将ueditor->http://www.wap.com/ueditor
	 * */
	'params'=>array(
	    // this is used in contact page
	    'adminEmail'=>'leijiao2010@gmail.com',
	    'imgurl'=>'http://www.mywap.com/wap/images/',
		'img_ueditor_old_js' =>'/\/ueditor/g',		
		'img_ueditor_old' => '/\/ueditor/',
		'img_ueditor_php' => '/http:\/\/www.mywap.com/',
		'img_ueditor' =>'http://www.mywap.com/ueditor',
	    'img_save_url'=>'../wap/images/',
	    'month'=>date('Ym',time()),
	    'language'=>'zh_cn',
	),
);
