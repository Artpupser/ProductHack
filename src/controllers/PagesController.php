<?php

namespace ProductHack\controllers;

use ProductHack\core\Controller;
use ProductHack\core\Request;
use ProductHack\core\Application;

class PagesController extends Controller
{
    public function catalog(Request $request) {
        return $this->render('catalog', [
            "page_title"=>"🍇 Винный каталог"
        ]);
    }

    public function main(Request $request) {
        return $this->render('main', [
            "page_title"=>"🍇 Винный магазин",
        ]);
    }

    public function aboutus(Request $request) {
        return $this->render('aboutus', [
            "page_title"=>"🍇 О нас",
        ]);
    }

    public function authorization(Request $request) {
        $this->layout="auth_workflow";
        return $this->render('authorization', [
            "page_title"=>"🍇 Авторизация пользователя",
        ]);
    }

    public function error(Request $request) {
        $code = Application::$app->response->getStatusCode();
        return $this->render('error', [
            "page_title"=>"🍇 Ошибка, " . $code,
            "code"=>$code,
            "message"=> Application::$app->errorMessage($code),
        ]);
    }
}