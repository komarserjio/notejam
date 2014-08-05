<?php

$params = require(__DIR__ . '/params.php');

$config = [
    'id' => 'basic',
    'basePath' => dirname(__DIR__),
    'layout'=>'base',
    'bootstrap' => ['log'],
    'components' => [
        'request' => [
            // !!! insert a secret key in the following (if it is empty) - this is required by cookie validation
            'cookieValidationKey' => 'qAEARuRBk0l-EWX0rSr6PPni6rgg3SEd',
        ],
        'cache' => [
            'class' => 'yii\caching\FileCache',
        ],
        'user' => [
            'identityClass' => 'app\models\User',
            'enableAutoLogin' => true,
            'loginUrl'=>'signin',
        ],
        'errorHandler' => [
            'errorAction' => 'note/error',
        ],
        'urlManager' => [
            'class' => 'yii\web\UrlManager',
            'enablePrettyUrl' => true,
            'showScriptName' => false,
            //'suffix' => '/',
            'rules' => [
                '' => 'note/list',

                'signup' => 'user/signup',
                'signin' => 'user/signin',
                'settings' => 'user/settings',
                'signout' => 'user/signout',
                'forgot-password' => 'user/forgot-password',

                'pads/create' => 'pad/create',
                'pads/<id:\d+>/edit' => 'pad/edit',
                'pads/<id:\d+>/delete' => 'pad/delete',
                'pads/<id:\d+>' => 'pad/view',

                'notes/create' => 'note/create',
                'notes/<id:\d+>/edit' => 'note/edit',
                'notes/<id:\d+>/delete' => 'note/delete',
                'notes/<id:\d+>' => 'note/view',
            ]
        ],
        'mailer' => [
            'class' => 'yii\swiftmailer\Mailer',
            // send all mails to a file by default. You have to set
            // 'useFileTransport' to false and configure a transport
            // for the mailer to send real emails.
            'useFileTransport' => true,
        ],
        'log' => [
            'traceLevel' => YII_DEBUG ? 3 : 0,
            'targets' => [
                [
                    'class' => 'yii\log\FileTarget',
                    'levels' => ['error', 'warning'],
                ],
            ],
        ],
        'db' => require(__DIR__ . '/db.php'),
    ],
    'params' => $params,
];

if (YII_ENV_DEV) {
    // configuration adjustments for 'dev' environment
    $config['bootstrap'][] = 'debug';
    $config['modules']['debug'] = 'yii\debug\Module';

    $config['bootstrap'][] = 'gii';
    $config['modules']['gii'] = 'yii\gii\Module';
}

return $config;
