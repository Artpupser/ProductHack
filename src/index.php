<!DOCTYPE html>
<html lang="en">
<?php 
require_once "./app/classes/Router.php";
$router = new Router();
$router->addFile("/", "main.php");
$router->addFile("/index", "main.php");
$router->addFile("/catalog", "catalog.php");
$router->route($router->requestUri());
?>
</html>