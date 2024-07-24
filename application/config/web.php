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
        'db' => $db,
        'urlManager' => [
            'enablePrettyUrl' => true,
            'showScriptName' => false,
            'enableStrictParsing' => false,
            'rules' => [
                [
                    'pattern' => '<language:\w+>/orders/<status:pending|inprogress|completed|canceled|error>',
                    'route' => 'order-listing/order/get',
                    'defaults' => ['status' => '', 'language' => 'en'],
                ],
                [
                    'pattern' => '<language:\w+>/orders/export/<status:pending|inprogress|completed|canceled|error>',
                    'route' => 'order-listing/order/export',
                    'defaults' => ['status' => '', 'language' => 'en'],
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
    ];

    $config['bootstrap'][] = 'gii';
    $config['modules']['gii'] = [
        'class' => 'yii\gii\Module',
    ];
}

return $config;
