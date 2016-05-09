<?php
require 'vendor/autoload.php';
require 'helper.php';

use Philo\Blade\Blade;

$views = __DIR__ . '/views';
$cache = __DIR__ . '/cache';
$error = __DIR__ . '/error';

$SCRIPT_NAME = preg_replace('/\/index.php/', '', $_SERVER['SCRIPT_NAME']);
$REQUEST_URI = preg_replace('/\/index.php/', '', $_SERVER['REQUEST_URI']);

if (!empty($SCRIPT_NAME)) {
    $SCRIPT_NAME = addcslashes($SCRIPT_NAME, '/');
    $REQUEST_URI = preg_replace('/' . $SCRIPT_NAME . '/', '', $REQUEST_URI);
}
$uri = explode('/', ltrim($REQUEST_URI, '/'));
$uri = implode('.', $uri);
if (empty($uri)) {
    $uri = 'index';
}

$file = ($REQUEST_URI == '/') ? $file = $REQUEST_URI . 'index' : $REQUEST_URI;
$file = $views . $file . '.blade.php';
$file = str_replace('/', '\\', $file);
if (!file_exists($file)) {
    $blade = new Blade($error, $cache);
    echo $blade->view()->make('404')->render();
    die();
}
$blade = new Blade($views, $cache);
echo $blade->view()->make($uri)->render();