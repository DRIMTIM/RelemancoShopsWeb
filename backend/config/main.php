<?php
$params = array_merge(
    require(__DIR__ . '/../../common/config/params.php'),
    require(__DIR__ . '/../../common/config/params-local.php'),
    require(__DIR__ . '/params.php'),
    require(__DIR__ . '/params-local.php')
);

return [
    'id' => 'app-backend',
    'basePath' => dirname(__DIR__),
    'controllerNamespace' => 'backend\controllers',
    'bootstrap' => ['log'],
    /*'modules' => [
         'user' => [
                'class' => 'dektrium\user\Module',
                'admins' => ['pelupotter']
            ],
    ],*/
    'modules' => [
        'user' => [
            // following line will restrict access to admin page
            'as backend' => 'dektrium\user\filters\BackendFilter',
            'admins' => ['pelupotter' , 'jonaf2103'],
            'controllers' => []
        ],
    ],
    'components' => [
        /*'user' => [
            'identityClass' => 'common\models\User',
            'enableAutoLogin' => true,
        ],*/
        'user' => [
            'identityCookie' => [
                'name'     => '_backendIdentity',
            ],
        ],
        'session' => [
            'name' => 'BACKENDSESSID',
        ],
        'view' => [
            'theme' => [
                'pathMap' => [
                    '@backend/views' => [
                        '@backend/themes/views',
                    ],
                    '@dektrium/user/views' => [
                        '@backend/themes/views/user'
                    ]
                ]
            ]
        ],
        'assetManager' => [
            'bundles' => [
                'dmstr\web\AdminLteAsset' => [
                    'skin' => 'skin-yellow',
                ],
                'dosamigos\google\maps\MapAsset' => [
                    'options' => [
                        'key' => 'AIzaSyCc8qdTE4hoIsnmWLGoGzhp0Djsgck8Kmk',
                        'language' => 'es',
                        'version' => '3.1.18'
                    ]
                ],
            ],
        ],
        /*'urlManager' => [
            'enablePrettyUrl' => true,
            'enableStrictParsing' => true,
            'showScriptName' => false,
            'rules' => [
                ['class' => 'yii\rest\UrlRule', 'controller' => 'providers'],
            ],
        ],
        'request' => [
            'parsers' => [
                'application/json' => 'yii\web\JsonParser',
            ]
        ],*/
        'urlManager' => [
            'class' => 'yii\web\UrlManager',
            // Disable index.php
            'showScriptName' => false,
            // Disable r= routes
            'enablePrettyUrl' => true,
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
        'errorHandler' => [
            'errorAction' => 'site/error',
        ],
    ],
    'params' => $params,
];
