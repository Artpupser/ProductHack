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
	public Database $database;
	public Request $request;
	public Session $sessions;

	public function __construct($rootPath, array $config)
	{
		$this->sessions = new Session();
		self::$app = $this;
		self::$ROOT_DIR = $rootPath;
		self::$VIEWS_DIR = pathCombine([self::$ROOT_DIR, '/views/']);
		$this->request = new Request();
		$this->response = new Response();
		$this->database = new Database($config['db']);
		$this->router = new Router($this->request, $this->response);
	}

	public function run()
	{
		echo $this->router->resolve();
	}

	public function errorMessage(int $code): string
	{
		$dict = [
			404 => "Page not found",
			400 => "Request not valid",
			403 => "Access denied",
		];
		return $dict[$code];
	}
}
