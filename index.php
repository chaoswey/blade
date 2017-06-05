<?php
require 'vendor/autoload.php';
require 'app/helper.php';

use App\Route;

$views = __DIR__ . '/resources/views';
$cache = __DIR__ . '/app/cache';
$error = __DIR__ . '/app/error';

$route = new Route($views, $error, $cache);
echo $route->views();