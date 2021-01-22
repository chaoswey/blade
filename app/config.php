<?php

return [
    'debug'       => true,
    'views'       => [
        'path'  => dirname(__DIR__).'/resources/views',
        'cache' => dirname(__DIR__).'/storage/cache',
        'error' => dirname(__DIR__).'/storage/error',
    ],
    'ignore'      => ['_layouts/*', '_partials/*'],
    'components'  => ['_components'],
    'config_path' => '_setting',
];