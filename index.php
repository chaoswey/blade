<?php
require 'vendor/autoload.php';

use App\Application;

$app = new Application();
$app->response()->send();