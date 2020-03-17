<?php
require 'vendor/autoload.php';

use App\Application;

(new Application())->response()->send();