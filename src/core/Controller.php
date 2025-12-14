<?php

namespace ProductHack\core;

class Controller
{
    public string $layout = 'workflow';

    public function render($view, $params = []) 
    {
        return Application::$app->router->renderView($view, $params);
    }
}