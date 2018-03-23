<?php

$yii = dirname(__FILE__) . '/yii-framework-1.1.13/yii.php';
$config = dirname(__FILE__) . '/protected/config/cron.php';

// remove the following lines when in production mode
defined('YII_DEBUG') or define('YII_DEBUG', true);
// specify how many levels of call stack should be shown in each log message
defined('YII_TRACE_LEVEL') or define('YII_TRACE_LEVEL', 3);

require_once($yii);
// creating and running console application
Yii::createConsoleApplication($config);
Settings::applySetting(); //override settings by values from database
Yii::app()->run();