<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
return array(
    // This path may be different. You can probably get it from `config/main.php`.
    'basePath'=>dirname(__FILE__).DIRECTORY_SEPARATOR.'..',
    'name'=>'Cron',
 
    'preload'=>array('log'),
 
    'import'=>array(
        'application.models.*',
        'application.components.*',
        'application.modules.admin.models.*',
        'application.modules.api.models.*',
        'application.modules.api.components.*',
        'application.extensions.yii-mail.*',
    ),
    // We'll log cron messages to the separate files
    'components'=>array(
        'log'=>array(
            'class'=>'CLogRouter',
            'routes'=>array(
                array(
                    'class'=>'CFileLogRoute',
                    'logFile'=>'cron.log',
                    'levels'=>'error, warning',
                ),
                array(
                    'class'=>'CFileLogRoute',
                    'logFile'=>'cron_trace.log',
                    'levels'=>'trace',
                ),
            ),
        ),

        // database settings are configured in database.php
        'db'=>require(dirname(__FILE__).'/database.php'),

        'mail' => array(
            'class' => 'application.extensions.yii-mail.YiiMail',
            'transportType'=>'smtp', /// case sensitive!
            'transportOptions'=>array(
                'host'=>'mail.spj.vn',
                'username'=>'abc',
                'password'=>'!%456!!19*&CaRe',
                'port'=>'587',
                'encryption'=>'tls',
                'timeout'=>'15',
            ),
            'viewPath' => 'application.mail',
            'logging' => true,
            'dryRun' => false
        ),
        'Smtpmail' => array(
            'class' => 'application.extensions.phpmailer.PHPMailer',
            'Host' => "mail.spj.vn",
            'Username' => 'nguyenpt@spj.vn',
            'Password' => '593d74ITquest*',
            'Mailer' => 'smtp',
            'Port' => 587,
            'SMTPAuth' => true,
        ),
    ),
);

