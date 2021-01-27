<?php

return [
    'debug'      => true,
    'views'      => [
        'path'  => dirname(__DIR__).'/resources/views',
        'cache' => dirname(__DIR__).'/storage/cache',
        'error' => dirname(__DIR__).'/storage/error',
    ],
    'ignore'     => ['_layouts/*', '_partials/*'],
    'guess'      => '_components',
    'components' => [],
    'route'      => [
        '_setting' => \App\Setting\AppSetting::class
    ],
];