<?php

return [
    'sourcePath'   => dirname( __DIR__ ) . '/frontend',
    'languages'    => ['de-DE'],
    'messagePath'  => dirname( __DIR__ ) . '/frontend/messages',
    'removeUnused' => true,
    'sort'         => true,
    'only'         => ['*.php'],
    'format'       => 'po',
    'markUnused'   => false,
];