<?php

return [
    'sourcePath'   => dirname( __DIR__),
    'languages'    => ['de-DE'],
    'translator'   => 'Yii::t',
    'sort'         => true,
    'removeUnused' => true,
    'markUnused'   => false,
    'only'         => ['*.php'],
    'except'       => [
        '.svn',
        '.git',
        '/messages',
        '/vendor',
        'console',
        'environments',
        'vagrant'
    ],
    'format'       => 'po',
    'messagePath'  => dirname( __DIR__ ) . '/common/messages',
];