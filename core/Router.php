<?php

class HttpRequest
{
    public $get;
    public $post;
    public $server;

    public function __construct($get, $post, $server)
    {
        $this->get = $get;
        $this->post = $post;
        $this->server = $server;
    }
}

class Router
{
    private $routes = [];
    private $container;

    public function __construct($container)
    {
        $this->container = $container;
    }

    public function get($path, $handler)
    {
        $this->routes['GET'][$path] = $handler;
    }

    public function post($path, $handler)
    {
        $this->routes['POST'][$path] = $handler;
    }
    
    public function delete($path, $handler)
    {
        $this->routes['DELETE'][$path] = $handler;
    }

    public function dispatch($url, $method)
    {
        if (isset($this->routes[$method])) {
            foreach ($this->routes[$method] as $route => $handler) {
                $routePattern = preg_replace('/\{[a-zA-Z0-9_]+\}/', '([a-zA-Z0-9_]+)', $route);
                $routePattern = "#^" . $routePattern . "$#";

                if (preg_match($routePattern, $url, $matches)) {
                    array_shift($matches);

                    $request = new HttpRequest($_GET, $_POST, $_SERVER);

                    preg_match_all('/\{([a-zA-Z0-9_]+)\}/', $route, $paramNames);
                    $paramNames = $paramNames[1];

                    $params = [];
                    foreach ($paramNames as $index => $paramName) {
                        $params[$paramName] = $matches[$index];
                    }

                    list($module, $controller, $method) = explode('@', $handler);
                    require_once "../modules/$module/controllers/$controller.php";

                    $controllerInstance = $this->container->resolve($controller);
                    call_user_func_array([$controllerInstance, $method], array_merge([$request], array_values($params)));
                    return;
                }
            }
        }

        http_response_code(404);
        echo "404 Not Found";
    }
}
