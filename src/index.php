<?php

require_once __DIR__.'/../vendor/autoload.php';

use ProductHack\core\Application;

$app = new Application(__DIR__);

$app->router->get('/', 'main');

$app->router->get('/catalog', 'catalog');

$app->router->post('/users', function() {
    return 'handling data';
});

$app->run();
