<?php

namespace Api;

use Slim\Factory\AppFactory;
use Slim\Middleware\Session;

require __DIR__ . '/../vendor/autoload.php';

$app = AppFactory::create();
$app->add(new Session(['autorefresh' => true, 'lifetime' => '1 hour',]));

(require __DIR__ . '/../config/routes.php')($app);

$app->run();
