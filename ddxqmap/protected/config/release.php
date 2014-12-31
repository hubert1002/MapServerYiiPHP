<?php

// uncomment the following to define a path alias
// Yii::setPathOfAlias('local','path/to/local-folder');

// This is the main Web application configuration. Any writable
// CWebApplication properties can be configured here.
return array(
	'basePath'=>dirname(__FILE__).DIRECTORY_SEPARATOR.'..',
	'name'=>'地图系统',

	// preloading 'log' component
	'preload'=>array('log'),

	// autoloading model and component classes
	'import'=>array(
		'application.models.*',
		'application.components.*',
        'application.vendors.jpush.*'
	),

	'modules'=>array(
		// uncomment the following to enable the Gii tool
		
		'gii'=>array(
			'class'=>'system.gii.GiiModule',
			'password'=>'password',
			// If removed, Gii defaults to localhost only. Edit carefully to taste.
		//	'ipFilters'=>array('10.192.248.94','::1'),
                        'ipFilters'=>array('10.192.73.13','::1'),
		),
		
	),

	// application components
	'components'=>array(

		'user'=>array(
			// enable cookie-based authentication
			'allowAutoLogin'=>true,
		),

		// uncomment the following to enable URLs in path-format

/*		'urlManager'=>array(
			'urlFormat'=>'path',
			'rules'=>array(
				'<controller:\w+>/<id:\d+>'=>'<controller>/view',
				'<controller:\w+>/<action:\w+>/<id:\d+>'=>'<controller>/<action>',
				'<controller:\w+>/<action:\w+>'=>'<controller>/<action>',
			),
		),
		*/

		// database settings are configured in database.php
        'db'=>array(
            'connectionString' => 'mysql:host=localhost;dbname=mapmgr',
            'emulatePrepare' => true,
            'username' => 'root',
            'password' => 'password',
            'charset' => 'utf8',
        ),

		//'db'=>require(dirname(__FILE__).'/database.php'),

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


        'cache'=>array(
            'class'=>'CDbCache',
        ),

	),

	// application-level parameters that can be accessed
	// using Yii::app()->params['paramName']
	'params'=>array(
        // this is used in contact page
        'adminEmail'=>'webmaster@example.com',
        'current_version'=>'1.0',
        'download_url'=>"http://www.eoemarket.com/download/242194_1",
        //小站登陆数据获取
        'remote_login_url' => 'http://fwztest.ddxq.mobi/delivery/deliveryMap/login',
        'remote_deliveryers_url' => 'http://fwztest.ddxq.mobi/delivery/deliveryMap/getDeliveryers',
        'remote_station_url' => 'http://fwztest.ddxq.mobi/delivery/deliveryMap/getStation',
        'remote_getunsignedorders_url' => 'http://fwztest.ddxq.mobi/delivery/deliveryMap/getUnsignedOrders',
        'remote_getusertask_url' => 'http://fwztest.ddxq.mobi/delivery/deliveryMap/getUserTask',
        'remote_getuserinfo_url' => 'http://fwztest.ddxq.mobi/delivery/deliveryMap/getUserInfo',
        'remote_mongodb_delivery' => 'mongodb://10.8.64.35:27017',
        'local_py_address_parser'=>'http://localhost:8000/getStandardAddress',//localhost:8000/getStandardAddress  http://10.8.64.81:8000/getStandardAddress
        'curl_timeout' => 5,
        'curl_connection_timeout' => 3
	),

/*    新版本需要修改
    current_version
    download_url
    userinfo_url
    remote_login_url


*/
);
