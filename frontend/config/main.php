<?php

use yii\filters\AccessControl;

$params = array_merge( require __DIR__ . '/../../common/config/params.php', require __DIR__ . '/../../common/config/params-local.php', require __DIR__ . '/params.php', require __DIR__ . '/params-local.php' );

return [
    'id'                  => 'bait-calc',
    'name'                => 'BaitCalc',
    'basePath'            => dirname( __DIR__ ),
    'bootstrap'           => ['log'],
    'language'            => 'de-DE',
    'controllerNamespace' => 'frontend\controllers',
    'components'          => [
        'request'      => [
            'csrfParam' => '_csrf-frontend',
        ],
        'user'         => [
            'identityClass'   => 'common\models\User',
            'enableAutoLogin' => true,
            'identityCookie'  => [
                'name'     => '_identity-frontend',
                'httpOnly' => true,
            ],
        ],
        'session'      => [
            // this is the name of the session cookie used for login on the frontend
            'name' => 'bait-calc',
        ],
        'log'          => [
            'traceLevel' => YII_DEBUG ? 3 : 0,
            'targets'    => [
                [
                    'class'  => \yii\log\FileTarget::class,
                    'levels' => [
                        'error',
                        'warning',
                    ],
                ],
            ],
        ],
        'errorHandler' => [
            'errorAction' => 'site/error',
        ],
        'urlManager'   => [
            'enablePrettyUrl' => true,
            'showScriptName'  => false,
            'rules'           => [],
        ],

    ],
    'as beforeRequest'    => [
        'class'  => AccessControl::class,
        'rules'  => [
            [
                'allow' => true,
                'roles' => ['@'],
            ],
        ],
        'except' => [
            'site/index',
            'site/about',
            'site/error',
            'site/signup',
            'site/login',
            'site/resend-verification-email',
            'site/request-password-reset',
            'site/reset-password',
            'site/verify-email',
            'gii',
        ],
    ],
    'params'              => $params,
];
