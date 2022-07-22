<?php


use Socket\Chat\Config\App;
use Socket\Chat\Config\Config;
use Socket\Chat\Routes\Router;
use Socket\Chat\Container;
//use Symfony\Component\Dotenv\Dotenv;


ini_set('display_errors',1);
error_reporting(E_ALL);


require_once __DIR__ . '/../vendor/autoload.php';

//$dotenv = new Dotenv();
//$dotenv->load();

$container = new Container();
$router    = new Router($container);

$router->run();

(new App(
    $router,
    ['uri' => $_SERVER['REQUEST_URI'], 'method' => $_SERVER['REQUEST_METHOD']],
    new Config($_ENV)
))->run();