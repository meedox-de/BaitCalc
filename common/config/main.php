<?php

return [
    'aliases' => [
        '@bower' => '@vendor/bower-asset',
        '@npm'   => '@vendor/npm-asset',
    ],
    'vendorPath' => dirname( __DIR__, 2 ) . '/vendor',
    'components' => [
        'cache' => [
            'class' => \yii\caching\FileCache::class,
        ],
        'i18n'         => [
            'translations' => [
                'common' => [
                    'class'          => 'yii\i18n\GettextMessageSource',
                    'basePath'       => '@common/messages',
                    'sourceLanguage' => 'en-US',
                    'useMoFile'      => false,
                    'catalog'        => 'messages',
                ],
            ],
        ],
    ],
];
