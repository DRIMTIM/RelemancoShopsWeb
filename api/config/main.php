<?php

$params = array_merge(
    require(__DIR__ . '/../../common/config/params.php'),
    require(__DIR__ . '/../../common/config/params-local.php'),
    require(__DIR__ . '/params.php'),
    require(__DIR__ . '/params-local.php')
);

return [
    'id' => 'app-api',
    'basePath' => dirname(__DIR__),
    'bootstrap' => ['log'],
    'modules' => [
        'v1' => [
            'basePath' => '@app/modules/v1',
            'class' => 'api\modules\v1\Module'
        ]
    ],
    'components' => [
        'request' => [
            'enableCookieValidation' => false,
            'enableCsrfValidation' => false,
            // Enable JSON Input:
            'parsers' => [
                'application/json' => 'yii\web\JsonParser',
            ]
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
        'urlManager' => [
            'enablePrettyUrl' => true,
            'enableStrictParsing' => true,
            'showScriptName' => false,
            'rules' => [

                'GET <apiv:v\d+>/comercios/obtenerproductos' => '<apiv>/comercios/obtenerproductos',
                'GET <apiv:v\d+>/comercios/obtenercomercios' => '<apiv>/comercios/obtenercomercios',
                'POST <apiv:v\d+>/relevadores/customoperation/<id:(.)+>' => '<apiv>/relevadores/customoperation',
                'POST <apiv:v\d+>/secure/login' => '<apiv>/secure/login',
                'POST <apiv:v\d+>/<controller:\w+>/<id:(.)+>' => '<apiv>/<controller>/create',


                'HEAD <apiv:v\d+>/<controller:\w+>/<operation:\w+>' => '<apiv>/<controller>/<operation>',
                'GET <apiv:v\d+>/<controller:\w+>/<operation:\w+>' => '<apiv>/<controller>/<operation>',
                'HEAD <apiv:v\d+>/<controller:\w+>/<operation:\w+>/<params:(.)+>' => '<apiv>/<controller>/<operation>',
                'GET <apiv:v\d+>/<controller:\w+>/<operation:\w+>/<params:(.)+>' => '<apiv>/<controller>/<operation>',
                'PUT <apiv:v\d+>/<controller:\w+>/<operation:\w+>/<params:(.)+>' => '<apiv>/<controller>/<operation>',
                'PATCH <apiv:v\d+>/<controller:\w+>/<operation:\w+>/<params:(.)+>' => '<apiv>/<controller>/<operation>',
                'DELETE <apiv:v\d+>/<controller:\w+>/<operation:\w+>/<params:(.)+>' => '<apiv>/<controller>/<operation>',

            ]
        ]
    ],
    'params' => $params,
];
