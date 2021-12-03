<?php

namespace App\Routes;

use Bramus\Router\Router;

$router = new Router;
$router->setNamespace('\App\Controllers');

$router->get('/', 'IndexController@index');

// Fallback Route
$router->set404('IndexController@notFound');

$router->run();