<?php

require_once __DIR__.'/../vendor/autoload.php';

use ProductHack\controllers\AuthorizationController;
use ProductHack\controllers\PagesController;
use ProductHack\core\Application;

$app = new Application(__DIR__);

// Страницы [Ну типа да]
$app->router->get('/',  [PagesController::class, 'main']);
$app->router->get('/index',  [PagesController::class, 'main']);
$app->router->get('/catalog', [PagesController::class, 'catalog']);
$app->router->get('/aboutus', [PagesController::class, 'aboutus']);
$app->router->get('/authorization', [PagesController::class, 'authorization']);
$app->router->get('*', [PagesController::class, 'error']); // Страница ошибки [Ну типа нет]

$app->router->post('/login', [AuthorizationController::class, 'login']);
$app->router->post('/registration', [AuthorizationController::class, 'registration']);
$app->router->post('/logout', [AuthorizationController::class, 'logout']);


$app->run();
