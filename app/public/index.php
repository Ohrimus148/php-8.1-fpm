<?php


use App\App;
use App\Config;

use App\Controllers\HomeController;

use App\Router;
use Socket\Chat\Container;
use Symfony\Component\Dotenv\Dotenv;


ini_set('display_errors',1);
error_reporting(E_ALL);


require_once __DIR__ . '/../vendor/autoload.php';

$dotenv = Dotenv();
$dotenv->load();



$container = new Container();
$router    = new Router($container);

$router
    ->get('/', [HomeController::class, 'index']);

(new App(
    $router,
    ['uri' => $_SERVER['REQUEST_URI'], 'method' => $_SERVER['REQUEST_METHOD']],
    new Config($_ENV)
))->run();