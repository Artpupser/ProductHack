<?php

namespace ProductHack\core;

class Router {

    protected array $routes = [];

    public Request $request;
    public Response $response;
    public Controller $controller;

    public function __construct(Request $request, Response $response)
    {
        $this->request = $request;
        $this->response = $response;
    }

    public function get($path, $callback)
    {
        $this->routes['get'][$path] = $callback;
    }

    public function post($path, $callback)
    {
        $this->routes['post'][$path] = $callback;
    }

    public function resolve()
    {
        $path = $this->request->getPath();
        $method = $this->request->getMethod();
        $callback = $this->routes[$method][$path] ?? false;
        $this->response->setStatusCode(200);
        if($callback === false || is_string($callback)) {
            $this->response->setStatusCode(404);
            $callback = $this->routes[$method]['*'];
        }
        if(is_array($callback)) {
            $this->controller = new $callback[0]();
            $callback[0] = $this->controller;
        }
        return call_user_func($callback, $this->request);
    }


    public function renderView($view, $params = []) {
        $layoutContent = $this->layoutContent($params);
        $viewContent = $this->viewContent($view, $params);
        return str_replace('{{content}}', $viewContent, $layoutContent);
    }

    public function renderContent($viewContent) {
        $layoutContent = $this->layoutContent();
        return str_replace('{{content}}', $viewContent, $layoutContent);
    }

    protected function layoutContent($params = []) {
        foreach ($params as $key => $value) { 
            $$key = $value;
        }
        ob_start();
        include_once Application::$VIEWS_DIR . '/layouts/' . $this->controller->layout . '.php';
        return ob_get_clean();
    }

    protected function viewContent($view, $params = []) {
        foreach ($params as $key => $value) { 
            $$key = $value;
        }
        ob_start();
        include_once Application::$VIEWS_DIR . $view . '.php';
        return ob_get_clean();
    }
}