<?php

namespace ProductHack\core;

abstract class Controller
{
    public string $layout = 'workflow';

    public function render($view, $params = []) 
    {
        return Application::$app->router->renderView($view, $params);
    }

    public function renderBadJson() {
        return Application::$app->router->renderContent("Bad request");
    }
    
    public function renderJson(Request $request) {
        return Application::$app->router->renderContent($request->getContentJson());
    }
}