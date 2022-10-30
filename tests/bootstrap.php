<?php

use Symfony\Component\Dotenv\Dotenv;

$_ENV['APP_ENV'] = $_SERVER['APP_ENV'] = 'test';

//\Symfony\Component\ErrorHandler\Debug::enable();

require dirname(__DIR__) . '/vendor/autoload.php';

(new Dotenv())->bootEnv(dirname(__DIR__) . '/.env.test');
