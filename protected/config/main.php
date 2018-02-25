<?php

// uncomment the following to define a path alias
// Yii::setPathOfAlias('local','path/to/local-folder');

// This is the main Web application configuration. Any writable
// CWebApplication properties can be configured here.
return array(
	'basePath'=>dirname(__FILE__).DIRECTORY_SEPARATOR.'..',
	'name'=>'Nha Khoa Việt Mỹ',
//        'theme' => 'blackboot',
        'theme' => 'bootstrap',
        //'theme' => 'gas',
    
	// preloading 'log' component
	'preload'=>array(
            'log',
            'booster',
            ),

	// autoloading model and component classes
	'import'=>array(
		'application.models.*',
		'application.components.*',
                'application.modules.admin.models.*',
                'application.modules.api.models.*',
                'application.modules.api.components.*',
                'application.extensions.yii-mail.*',
	),

	'modules'=>array(
		// uncomment the following to enable the Gii tool
		'gii'=>array(
			'class'=>'system.gii.GiiModule',
			'password'=>'123',
			// If removed, Gii defaults to localhost only. Edit carefully to taste.
			'ipFilters'=>array('127.0.0.1','::1'),
		),
                'admin',            // Admin module
                'api',              // API module
                'front',            // Front-end module
	),

	// application components
	'components'=>array(

		'user'=>array(
			// enable cookie-based authentication
			'allowAutoLogin'=>true,
		),

		// uncomment the following to enable URLs in path-format
		'urlManager'=>array(
			'urlFormat'=>'path',
			'rules'=>array(
				'<controller:\w+>/<id:\d+>'=>'<controller>/view',
				'<controller:\w+>/<action:\w+>/<id:\d+>'=>'<controller>/<action>',
				'<controller:\w+>/<action:\w+>'=>'<controller>/<action>',
			),
		),

		// database settings are configured in database.php
		'db'=>require(dirname(__FILE__).'/database.php'),

		'errorHandler'=>array(
			// use 'site/error' action to display errors
			'errorAction'=>YII_DEBUG ? null : 'site/error',
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
                'format' => array(
                    'class' => 'application.components.CmsFormatter',
                ),
                'booster' => array(
                    'class' => 'application.extensions.yiibooster.components.Booster',
                ),
                'geoip' => array(
                    'class' => 'application.extensions.geoip.CGeoIP',
                    'filename' => dirname(__FILE__).'/../../upload/GeoLiteCity.dat',
                    'mode' => 'STANDARD',
                ),

                'mail' => array(
                    'class' => 'application.extensions.yii-mail.YiiMail',
                    'transportType'=>'smtp', /// case sensitive!
                    'transportOptions'=>array(
                        'host'=>'mail.spj.vn',
                        'username'=>'abc',
                        'password'=>'!%456!!19*&CaRe',
                        'port'=>'465',
                        'encryption'=>'ssl',
                        'timeout'=>'120',
                    ),
                    'viewPath' => 'application.mail',
                    'logging' => true,
                    'dryRun' => false
                ),
	),

	// application-level parameters that can be accessed
	// using Yii::app()->params['paramName']
	'params'=>array(
		// this is used in contact page
		'adminEmail'=>'webmaster@example.com',
	),
);
