<?php

include_once 'info.php';

// uncomment the following to define a path alias
// Yii::setPathOfAlias('local','path/to/local-folder');
Yii::setPathOfAlias('bootstrap', dirname(__FILE__) . '/../extensions/bootstrap');
// This is the main Web application configuration. Any writable
// CWebApplication properties can be configured here.
return array(
    'basePath' => dirname(__FILE__) . DIRECTORY_SEPARATOR . '..',
    'name' => WEBSITE_NAME,
    'theme' => WEBSITE_THEME,
    // preloading 'log' component
    'preload' => array(
        'log',
        'booster',
    ),
    // autoloading model and component classes
    'import' => array(
        'application.models.*',
        'application.components.*',
        'application.components.widgets.*',
        'application.components.email.*',
        'application.components.sms.*',
        'application.modules.admin.models.*',
        'application.modules.api.models.*',
        'application.modules.api.components.*',
        'application.extensions.yii-mail.*',
        'application.extensions.phpmailer.*',
        'application.extensions.EPhpThumb.*',
        'application.extensions.phpexcel.*',
        'application.extensions.phpexcel.Classes.*',
//                'application.extensions.phpexcel.Classes.PHPExcel.*',
        'application.components.widgets.*',
        'application.behaviors.ActiveRecordLogableBehavior',
        'application.modules.hr.models.*',
        'application.modules.product.models.*',
        'bootstrap.helpers.*',
        'bootstrap.behaviors.TbWidget',
        'bootstrap.widgets.*',
    ),
    'modules' => array(
        // uncomment the following to enable the Gii tool
        'gii' => array(
            'class' => 'system.gii.GiiModule',
            'password' => '123',
            // If removed, Gii defaults to localhost only. Edit carefully to taste.
            'ipFilters' => array('127.0.0.1', '::1'),
        ),
        'admin',        // Admin module
        'api',          // API module
        'front',        // Front-end module
        'hr',           // Hr module
        'product',      // Product module
    ),
    // application components
    'components' => array(
        'user' => array(
            // enable cookie-based authentication
            'allowAutoLogin' => true,
        ),
        // uncomment the following to enable URLs in path-format
        'urlManager' => array(
            'showScriptName' => true,
            'urlFormat' => 'path',
            'rules' => array(
                '<controller:\w+>/<id:\d+>' => '<controller>/view',
                '<controller:\w+>/<action:\w+>/<id:\d+>' => '<controller>/<action>',
                '<controller:\w+>/<action:\w+>' => '<controller>/<action>',
                '<url:(admin|member)>' => '<url>/site/',
            ),
        ),
        // database settings are configured in database.php
        'db' => require(dirname(__FILE__) . '/database.php'),
        'errorHandler' => array(
            // use 'site/error' action to display errors
            'errorAction' => YII_DEBUG ? null : 'site/error',
        ),
        'log' => array(
            'class' => 'CLogRouter',
            'routes' => array(
                array(
                    'class' => 'CFileLogRoute',
                    'levels' => 'error, warning',
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
            'filename' => dirname(__FILE__) . '/../../upload/GeoLiteCity.dat',
            'mode' => 'STANDARD',
        ),
        'mail' => array(
            'class' => 'application.extensions.yii-mail.YiiMail',
            'transportType' => 'smtp', /// case sensitive!
            'transportOptions' => array(
                'host' => MAIL_HOST,
                'username' => MAIL_HOST_USERNAME,
                'password' => MAIL_HOST_PASSWORD,
                'port' => MAIL_HOST_PORT,
                'encryption' => 'ssl',
                'timeout' => '10',
            ),
            'viewPath' => 'application.mail',
            'logging' => true,
            'dryRun' => false
        ),
        'bootstrap' => array(
            'class' => 'bootstrap.components.TbApi',
//            'class' => 'bootstrap.components.Bootstrap',
//            'cdnurl'=>"https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/",
            'cdnUrl' => "https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/",
        ),
    ),
    // application-level parameters that can be accessed
    // using Yii::app()->params['paramName']
    'params' => array(
        'adminEmail' => MAIL_ADMIN_EMAIL, // this is used in contact page
        'niceditor_list_buttons' => array(
            'xhtml', 'bold', 'italic', 'underline', 'indent', 'outdent', 'ol',
            'ul', 'fontSize', 'left', 'center', 'right', 'justify', 'forecolor',
            'bgcolor', 'image', 'upload'
        ),
    ),
);
