<?php

namespace ProductHack\core;

class Router {

    protected array $routes = [];

    public Request $request;
    public Response $response;
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
        Application::$app->response->setStatusCode(200);
        if($callback === false) {
            Application::$app->response->setStatusCode(404);
            return $this->renderView('error');
        }
        if(is_string($callback)) {
            return $this->renderView($callback);
        }
        return call_user_func($callback);
    }

    public function renderView($view) {
        $layoutContent = $this->layoutContent();
        $viewContent = $this->viewContent($view);
        return str_replace('{{content}}', $viewContent, $layoutContent);
    }

    public function renderContent($viewContent) {

    }

    protected function layoutContent() {
        ob_start();
        include_once Application::$VIEWS_DIR.'/layouts/workflow.php';
        return ob_get_clean();
    }

    protected function viewContent($view) {
        ob_start();
        include_once Application::$VIEWS_DIR . $view . '.php';
        return ob_get_clean();
    }
}