#!/usr/bin/env php
<?php
define('BLADE_START', microtime(true));

require __DIR__.'/vendor/autoload.php';

use Symfony\Component\Console\Application;
use App\Commands\Generator;

$application = new Application();
$application->add(new Generator());
$application->run();