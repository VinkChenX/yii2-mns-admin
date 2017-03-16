<?php

$params = require(__DIR__ . '/params.php');
$privateConfigFile = __DIR__ . '/private.php';//私有配置文件 如果有 则覆盖下面配置中的数据
    
$config = [
    'id' => 'basic',
    'language'=>'zh-cn',
    'basePath' => dirname(__DIR__),
    'bootstrap' => ['log'],
    'components' => [
        'request' => [
            // !!! insert a secret key in the following (if it is empty) - this is required by cookie validation
            'cookieValidationKey' => 'MjWtStooZHzIXeczatR2NIWo6qJFwy4Y',
        ],
        'cache' => [
            'class' => 'yii\caching\FileCache',
        ],
        'user' => [
            'identityClass' => 'app\models\User',
            'enableAutoLogin' => true,
        ],
        'errorHandler' => [
            'errorAction' => 'site/error',
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
        'urlManager' => [
            'enablePrettyUrl' => true,
            'showScriptName' => false,
            'rules' => [
            ],
        ],
        'mns'=>[
            'class'=>'yii\mns\Mns',
            'accessKeyId'=>'LTAIbhv28NRSuxWU',
            'AccessKeySecret'=>'ChjbZ35CuGSdErFfqMyvd2hIVLHq1N',
            'endpoint'=>'http://1921581007675842.mns.cn-hangzhou.aliyuncs.com/'
        ],
    ],
    'params' => $params,
];

if(file_exists($privateConfigFile)) {
    $config = yii\helpers\ArrayHelper::merge($config, require $privateConfigFile);
}

if (YII_ENV_DEV) {
    // configuration adjustments for 'dev' environment
    $config['bootstrap'][] = 'debug';
    $config['modules']['debug'] = [
        'class' => 'yii\debug\Module',
        // uncomment the following to add your IP if you are not connecting from localhost.
        //'allowedIPs' => ['127.0.0.1', '::1'],
    ];

    $config['bootstrap'][] = 'gii';
    $config['modules']['gii'] = [
        'class' => 'yii\gii\Module',
        // uncomment the following to add your IP if you are not connecting from localhost.
        //'allowedIPs' => ['127.0.0.1', '::1'],
    ];
}

return $config;
