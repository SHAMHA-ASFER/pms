<?php
require_once __DIR__ ."/Errors.php";
class Router {
    private $routes = [];
    private $middlewares = [];
    public function addRoute($method , $path , $callback , $middleware = null){
        $meth = strtolower($method);
        $this->routes[$meth][$path] = $callback;
        if($middleware != null){
            $this->middlewares[$meth][$path] = $middleware;
        }
    }

    public function resolveRoute(Request $request){
        $method = strtolower($request->getMethod());
        $path = $request->getPath();
        $error_handler = new ErrorHandler();

        if(isset($this->routes[$method][$path])){
            if(isset($this->middlewares[$method][$path])){
                $middleware = $this->middlewares[$method][$path];
                $middle_Controller = new $middleware[0]();
                $middleMethod = $middleware[1];
                call_user_func([$middle_Controller , $middleMethod]);
            }

            $callback = $this->routes[$method][$path];

            if(is_array($callback)){
                $controller = new $callback[0]();
                $controller_method = $callback[1];
                return call_user_func([$controller , $controller_method]);
            } else{
                $error_handler->handle(404);
            }
        }
    }
}