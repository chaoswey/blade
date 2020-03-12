<?php

return [
    'debug'       => true,
    'views'       => [
        'path'  => dirname(__DIR__) . '/resources/views',
        'cache' => __DIR__ . '/cache',
        'error' => __DIR__ . '/error',
    ],
    'ignore'      => [
        '_layouts/*',
        '_partials/*'
    ],
    'config_path' => 'config',
];