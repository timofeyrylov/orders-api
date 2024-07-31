<?php

$params = require __DIR__ . '/params.php';
$db = require __DIR__ . '/db.php';

$config = [
    'id' => 'basic',
    'language' => $_ENV['APP_LANGUAGE'],
    'basePath' => dirname(__DIR__),
    'bootstrap' => ['log'],
    'aliases' => [
        '@bower' => '@vendor/bower-asset',
        '@npm'   => '@vendor/npm-asset',
        '@OrderListing' => '@app/modules/OrderListing'
    ],
    'components' => [
        'request' => [
            'cookieValidationKey' => 'PM4kGzpqSWrGWnQ3HQBJG8rRTLd9NfFL',
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
        'log' => [
            'traceLevel' => YII_DEBUG ? 3 : 0,
            'targets' => [
                [
                    'class' => 'yii\log\FileTarget',
                    'levels' => ['error', 'warning'],
                ],
            ],
        ],
        'i18n' => [
            'translations' => [
                '*' => [
                    'class' => 'yii\i18n\PhpMessageSource',
                    'basePath' => '@app/messages',
                    'fileMap'  => [
                        'application' => 'application.php',
                        'orders' => 'orders.php',
                    ]
                ]
            ]
        ],
        'db' => $db,
        'urlManager' => [
            'enablePrettyUrl' => true,
            'showScriptName' => false,
            'enableStrictParsing' => false,
            'rules' => [
                [
                    'pattern' => '/<status>',
                    'route' => 'order-listing/order/listing',
                    'defaults' => ['status' => ''],
                ],
                [
                    'pattern' => '/export/<status>',
                    'suffix' => '/',
                    'route' => 'order-listing/order/export',
                    'defaults' => ['status' => ''],
                ]
            ]
        ]
    ],
    'params' => $params,
    'modules' => [
        'order-listing' => [
            'class' => 'OrderListing\Module'
        ]
    ]
];

if (YII_ENV_DEV) {
    $config['bootstrap'][] = 'debug';
    $config['modules']['debug'] = [
        'class' => 'yii\debug\Module',
        'allowedIPs' => ['127.0.0.1', '::1', '192.168.65.1'],
        'traceLine' => '<a href="phpstorm://open?{file}=%f&{line}=%l">{file}:{line}</a>'
    ];

    $config['bootstrap'][] = 'gii';
    $config['modules']['gii'] = [
        'class' => 'yii\gii\Module',
        'allowedIPs' => ['127.0.0.1', '::1', '192.168.65.1']
    ];
}

return $config;
