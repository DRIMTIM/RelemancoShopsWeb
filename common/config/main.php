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
    /*'modules' => [
    	'gii' => [
		    'class' => 'yii\gii\Module',
		    'allowedIPs' => ['127.0.0.1', '::1', '192.168.0.*', '192.168.178.20'] // adjust this to your needs
		],
    ]*/
];
