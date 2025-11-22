<?php 
require_once "config.php";
require_once "./app/utils/debug.php";

final class Router {

    private array $routes = [];

    public function __construct() {

    }

    public function requestUri() : string {
        return parse_url($_SERVER["REQUEST_URI"], PHP_URL_PATH);
    }

    public function addHandler(string $path, Closure $handler):void {
        $this->routes[$path] = $handler;
    }

    public function addFile(string $path, string $phpFilePath):void {
        $this->routes[$path] = $phpFilePath;
    }

    public function remove(string $path):void {
        unset($this->routes[$path]);
    }

    public function route():void {
        $uri = $this->requestUri();
        if (array_key_exists($uri, $this->routes)) {
            try {
                $obj = $this->routes[$uri];
                if (gettype($obj)) {
                    $this->pageHandler($obj);
                    return;
                }
                call_user_func($obj);
            } catch (\Throwable $th) {
                $throw_message = $th->getMessage();
                $this->errorPageHandler($th->getCode(), $throw_message);
                server_error($throw_message);
            }
            return;
        }
        $this->errorPageHandler(404, "Page <" . $uri . "> not found");
    }
    //Handlers
    private function errorPageHandler(int $error_code, string $message = "You catch error") : void {
        include_once VIEWS_DIR . 'error.php';
    }

    private function pageHandler($path) : void {
        include_once VIEWS_DIR . $path;
    }
}

?>