<?php
require 'vendor/autoload.php';
require 'app/helper.php';

use Symfony\Component\Debug\Debug;
use App\Route;

const DEBUG = true;

$views = __DIR__ . '/resources/views';
$cache = __DIR__ . '/app/cache';
$error = __DIR__ . '/app/error';

$route = new Route($views, $error, $cache);

if (DEBUG) {
    Debug::enable();
    echo $route->views();
} else {
    try {
        echo $route->views();
    } catch (Exception $e) {
        echo $route->error();
    }
}