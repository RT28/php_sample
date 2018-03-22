<?php
$params = array_merge(
    require(__DIR__ . '/../../common/config/params.php'),
    require(__DIR__ . '/../../common/config/params-local.php'),
    require(__DIR__ . '/params.php'),
    require(__DIR__ . '/params-local.php')
);

return [
    'id' => 'app-partner',
    'basePath' => dirname(__DIR__),
    'controllerNamespace' => 'partner\controllers',
	 'defaultRoute' => 'site/index',
    'bootstrap' => ['log'],
    'modules' => [
        'university' => [
            'class' => 'partner\modules\university\University',
        ],
        'consultant' => [
            'class' => 'partner\modules\consultant\Consultant',
        ], 
		'agency' => [
				'class' => 'partner\modules\agency\Agency',
			],
		'employee' => [
				'class' => 'partner\modules\employee\Employee',
			], 
		'gridview' => [
			'class' => '\kartik\grid\Module',
			 'downloadAction' => 'gridview/export/download',
			//'downloadAction' => 'export',
		],
    ],
    'aliases' => [
      '@frontend2' => '@common/../partner', 
    ],
    'components' => [
        'request' => [
            'csrfParam' => '_csrf-partner',
			'enableCsrfValidation' => false
        ],
        'user' => [
            'identityClass' => 'partner\models\PartnerLogin',
            'enableAutoLogin' => true,
            'identityCookie' => ['name' => '_identity-partner', 'httpOnly' => true],
        ],
        'session' => [
            // this is the name of the session cookie used for login on the partner
            'name' => 'advanced-partner',
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
		'mailer' => [
            'class' => 'yii\swiftmailer\Mailer',
            'useFileTransport' => false,
			'viewPath' => '@common/mail',
            'transport' => [
                'class' => 'Swift_SmtpTransport',
                'host' => 'smtp.gmail.com',
                'username' => 'gotouniversity.super@gmail.com',
                'password' => 'super12#$',
                'port' => '587',
                'encryption' => 'tls',
            ]
        ],
		
        /*
        'urlManager' => [
            'enablePrettyUrl' => true,
            'showScriptName' => false,
            'rules' => array(
                '<controller:\w+>/<id:\d+>' => '<controller>/view',
                '<controller:\w+>/<action:\w+>/<id:\d+>' => '<controller>/<action>',
                '<controller:\w+>/<action:\w+>' => '<controller>/<action>',
            ),

        ],
        */
    ],
    'params' => $params,
];
