<?php

require_once __DIR__ . '/../vendor/autoload.php';

use ProductHack\controllers\AuthorizationController;
use ProductHack\controllers\FileController;
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
$pages = new PagesController();
//get
$app->router->create_get_route(['/', '/index', '/home', '/main'], [PagesController::class, 'main']);
$app->router->create_get_route(['/test'], [PagesController::class, 'test']);
$app->router->create_get_route(['/catalog'], [PagesController::class, 'catalog']);
$app->router->create_get_route(['/aboutus'], [PagesController::class, 'aboutus']);
$app->router->create_get_route(['/admin'], [PagesController::class, 'admin']);
$app->router->create_get_route(['/profile'], [PagesController::class, 'profile']);
$app->router->create_get_route(['/card_product'], [PagesController::class, 'card_product']);
$app->router->create_get_route(['/payment'], [PagesController::class, 'payment']);
$app->router->create_get_route(['/contacts'], [PagesController::class, 'contacts']);
$app->router->create_get_route(['/authorization'], [PagesController::class, 'authorization']);
$app->router->create_get_route(['/api/public/file/'], [FileController::class, 'file']);


//post
$app->router->create_post_route(['/api/product/create'], [ProductController::class, 'create']);
$app->router->create_post_route(['/api/product/delete'], [ProductController::class, 'delete']);
$app->router->create_post_route(['/api/product/change'], [ProductController::class, 'change']);
$app->router->create_post_route(['/api/user/login'], [AuthorizationController::class, 'login']);
$app->router->create_post_route(['/api/user/send_code'], [AuthorizationController::class, 'sendCode']);
$app->router->create_post_route(['/api/user/registration'], [AuthorizationController::class, 'registration']);
$app->router->create_post_route(['/api/user/logout'], [AuthorizationController::class, 'logout']);


$app->run();
