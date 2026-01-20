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
	public ErrorStack $error;

	public function __construct($rootPath, array $config)
	{
		$this->error = new ErrorStack();
		$this->sessions = new Session();
		self::$app = $this;
		self::$ROOT_DIR = $rootPath;
		self::$VIEWS_DIR = pathCombine([self::$ROOT_DIR, '/views/']);
		$this->request = new Request();
		$this->response = new Response();
		$this->database = new Database($config['db']);
		$this->router = new Router($this->request, $this->response);
	}

	public function valid_files()
	{
		if ($_FILES['uploaded_file']['error'] === UPLOAD_ERR_OK) {
			$fileType = $_FILES['uploaded_file']['type'];

			// Разрешите только определенные типы файлов
			$allowedTypes = ['image/jpeg', 'image/png', 'application/pdf'];
			if (!in_array($fileType, $allowedTypes)) {
				die("Ошибка: тип файла не поддерживается.");
			}

			// Переместите файл в безопасное место
			move_uploaded_file($_FILES['uploaded_file']['tmp_name'], 'uploads/' . $_FILES['uploaded_file']['name']);
		}
	}

	public function run()
	{
		echo $this->router->resolve();
	}
}
