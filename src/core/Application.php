<?php

namespace ProductHack\core;

use function Cake\Core\pathCombine;

class Application 
{
    public static string $ROOT_DIR;
    public static string $VIEWS_DIR;
    public static Application $app;
    public Router $router;
    public Response $response;
    public Request $request;

    public function __construct($rootPath)
    {
        self::$app = $this;
        self::$ROOT_DIR = $rootPath;
        self::$VIEWS_DIR = pathCombine([self::$ROOT_DIR, '/views/']);
        $this->request = new Request();
        $this->response = new Response();
        $this->router = new Router($this->request, $this->response);
    }

    public function run()
    {
        echo $this->router->resolve();
    }
}