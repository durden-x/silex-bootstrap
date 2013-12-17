<?php

require_once __DIR__ . '/../vendor/autoload.php';

Symfony\Component\Debug\Debug::enable();

$app = new Silex\Application();

require __DIR__ . '/../resources/config/local.php';
require __DIR__ . '/../src/loader.php';

$app->run();