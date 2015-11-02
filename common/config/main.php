<?php
return [
    'language' => 'en-US',
    'vendorPath' => dirname(dirname(__DIR__)) . '/vendor',
    'components' => [
        'cache' => [
            'class' => 'yii\caching\FileCache',
        ],

        'i18n' => [
            'translations' => [
                '*' => [
                    'class' => 'yii\i18n\PhpMessageSource'
                ],
            ],
        ],
        'mailer' => [
                    'class' => 'yii\swiftmailer\Mailer',
                    'transport' => [
                        'class' => 'Swift_SmtpTransport',
                        'host' => 'smtp.gmail.com',
                        'username' => 'usu...@gmail.com',
                        'password' => 'password',
                        'port' => '587',
                        'encryption' => 'tls',
                    ],
                ]

    ],
    'modules' => [
        'user' => [
            'class' => 'dektrium\user\Module',
            'modelMap' => [
                'RegistrationForm' => 'app\models\RegistrationForm',
            ],
            // you will configure your module inside this file
            // or if need different configuration for frontend and backend you may
            // configure in needed configs
        ],
    ]
];
