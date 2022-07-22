<?php

declare(strict_types=1);

namespace Socket\Chat\Routes;

use App\Exceptions\RouteNotFoundException;
use Socket\Chat\Container;

class Router
{
    private array $routes = [];

    public function __construct(private Container $container)
    {
    }

    public function register(string $requestMethod, string $route, callable|array $action): self
    {
        $this->routes[$requestMethod][$route] = $action;

        return $this;
    }

    public function get(string $route, callable|array $action): self
    {
        return $this->register('get', $route, $action);
    }

    public function post(string $route, callable|array $action): self
    {
        return $this->register('post', $route, $action);
    }

    public function routes(): array
    {
        return $this->routes;
    }

    public function resolve(string $requestUri, string $requestMethod)
    {
        $route = explode('?', $requestUri)[0];
        $action = $this->routes[$requestMethod][$route] ?? null;

        if (! $action) {
            throw new RouteNotFoundException();
        }

        if (is_callable($action)) {
            return call_user_func($action);
        }

        [$class, $method] = $action;

        if (class_exists($class)) {
            $class = $this->container->get($class);

            if (method_exists($class, $method)) {
                return call_user_func_array([$class, $method], []);
            }
        }

        throw new RouteNotFoundException();
    }

    /**
     * Возвращает строку запроса
     */
    private function getURI()
    {
        if (!empty($_SERVER['REQUEST_URI'])) {
            return trim($_SERVER['REQUEST_URI'], '/');
        }
    }

    /**
     * Метод для обработки запроса
     */
    public function run()
    {
        // Получаем строку запроса
        $uri = $this->getURI();

        // Проверяем наличие такого запроса в массиве маршрутов (routes.php)
        foreach ($this->routes as $uriPattern => $path) {

            // Сравниваем $uriPattern и $uri
            if (preg_match("~$uriPattern~", $uri)) {

                // Получаем внутренний путь из внешнего согласно правилу.
                $internalRoute = preg_replace("~$uriPattern~", $path, $uri);

                // Определить контроллер, action, параметры

                $segments = explode('/', $internalRoute);

                $controllerName = array_shift($segments) . 'Controller';
                $controllerName = ucfirst($controllerName);

                $actionName = 'action' . ucfirst(array_shift($segments));

                $parameters = $segments;

                // Подключить файл класса-контроллера
                $controllerFile = ROOT . '/controllers/' .
                    $controllerName . '.php';

                if (file_exists($controllerFile)) {
                    include_once($controllerFile);
                }

                // Создать объект, вызвать метод (т.е. action)
                $controllerObject = new $controllerName;

                /* Вызываем необходимый метод ($actionName) у определенного
                 * класса ($controllerObject) с заданными ($parameters) параметрами
                 */
                $result = call_user_func_array(array($controllerObject, $actionName), $parameters);

                // Если метод контроллера успешно вызван, завершаем работу роутера
                if ($result != null) {
                    break;
                }
            }
        }
    }




}
