<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <?php 
    require_once "./app/classes/Router.php";
    $router = new Router();
    $router->addFile("/", "main.php");
    $router->route($router->requestUri());
    ?>
</body>
</html>