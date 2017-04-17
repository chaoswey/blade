<?php
require 'vendor/autoload.php';
require 'app/helper.php';

use App\Route;

$views = __DIR__ . '/resources/views';
$cache = __DIR__ . '/app/cache';
$error = __DIR__ . '/app/error';

$request = new Route($views, $error, $cache);
echo $request->views();