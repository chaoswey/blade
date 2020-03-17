<?php

return [
    'debug'       => true,
    'views'       => [
        'path'  => dirname(__DIR__) . '/resources/views',
        'cache' => __DIR__ . '/storage/cache',
        'error' => __DIR__ . '/storage/error',
    ],
    'ignore'      => [
        '_layouts/*',
        '_partials/*',
        '_components/*',
    ],
    'config_path' => '_setting',
];