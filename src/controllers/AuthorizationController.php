<?php

namespace ProductHack\controllers;

use ProductHack\core\Application;
use ProductHack\core\Controller;
use ProductHack\core\Request;

class AuthorizationController extends Controller
{

    public function registration(Request $request) {
                $this->layout="auth_workflow";
        return Application::$app->router->renderContent($request->getContentJson());
    }

    public function login(Request $request) {
                $this->layout="auth_workflow";
        return Application::$app->router->renderContent($request->getContentJson());
    }
  
    public function logout(Request $request) {
                $this->layout="auth_workflow";
        return Application::$app->router->renderContent($request->getContentJson());
    }
}