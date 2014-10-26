#!/usr/bin/env php
<?php

require 'vendor/autoload.php';

use Symfony\Component\ClassLoader\UniversalClassLoader;
use Symfony\Component\Console\Application;
use App\Command;

$loader = new UniversalClassLoader();
$loader->register();
$loader->registerNamespace('Console', __DIR__.'/src');
$loader->registerNamespace('App', __DIR__);


$application = new Application();
$application->add(new Command\TaskCommand());
$application->run();
