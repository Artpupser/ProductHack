<?php

require_once __DIR__ . '/../vendor/autoload.php';

use ProductHack\controllers\AuthorizationController;
use ProductHack\controllers\ProductController;
use ProductHack\controllers\PagesController;
use ProductHack\core\Application;

$dotenv = Dotenv\Dotenv::createImmutable(__DIR__ . '/../');
$dotenv->load();

$config = [
	'db' => [
		'host' => $_ENV['DB_HOST'],
		'name' => $_ENV['DB_NAME'],
		'password' => $_ENV['DB_PASS'],
		'user' => $_ENV['DB_USER'],
		'port' => $_ENV['DB_PORT'],
		'adapter' => $_ENV['DB_ADAPTER']
	],
];
$app = new Application(__DIR__, $config);

//get
$app->router->get('/',  [PagesController::class, 'main']);
$app->router->get('/index',  [PagesController::class, 'main']);
$app->router->get('/home', [PagesController::class, 'main']);
$app->router->get('/main', [PagesController::class, 'main']);

$app->router->get('/catalog', [PagesController::class, 'catalog']);
$app->router->get('/aboutus', [PagesController::class, 'aboutus']);
$app->router->get('/admin', [PagesController::class, 'admin']);
$app->router->get('/user', [PagesController::class, 'user']);
$app->router->get('/card_product', [PagesController::class, 'card_product']);
$app->router->get('/contacts', [PagesController::class, 'contacts']);
$app->router->get('/authorization', [PagesController::class, 'authorization']);
$app->router->get('*', [PagesController::class, 'error']);


//post
$app->router->post('/api/product/create', [ProductController::class, 'create']);
$app->router->post('/api/product/delete', [ProductController::class, 'delete']);
$app->router->post('/api/product/change', [ProductController::class, 'change']);

$app->router->post('/api/user/login', [AuthorizationController::class, 'login']);
$app->router->post('/api/user/send_code', [AuthorizationController::class, 'send_code']);
$app->router->post('/api/user/registration', [AuthorizationController::class, 'registration']);
$app->router->post('/api/user/logout', [AuthorizationController::class, 'logout']);


$app->run();
