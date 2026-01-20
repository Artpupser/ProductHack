<?php

namespace ProductHack\core;

use ProductHack\controllers\PagesController;

class Router
{

	protected array $routes = [];

	public Request $request;
	public Response $response;
	public Controller $controller;

	public function __construct(Request $request, Response $response)
	{
		$this->request = $request;
		$this->response = $response;
	}

	public function create_get_route(array $paths, array $userCallback)
	{
		foreach ($paths as $item) {
			$this->routes['get'][$item] = $userCallback;
		}
	}

	public function create_post_route(array $paths, array $userCallback)
	{
		foreach ($paths as $item) {

			$this->routes['post'][$item] = $userCallback;
		}
	}

	public function resolve()
	{
		$path = $this->request->getPath();
		$method = $this->request->getMethod();
		$callback = $this->routes[$method][$path] ?? null;
		$this->response->setStatusCode(200);
		$result = null;
		if ($callback !== null) {
			$this->controller = new $callback[0]();
			$callback[0] = $this->controller;
			$result = $callback($this->request);
		} else {
			Application::$app->error->pushServerError(404);
		}
		if (Application::$app->error->serverErrorsIsEmpty()) {
			return $result;
		}
		return $this->renderError();
	}

	private function renderError(): string
	{
		$this->controller ??= new PagesController();
		return $this->renderView("error", ["errors" => Application::$app->error->getServerErrors()]);
	}

	public function renderView($view, $params = []): string
	{
		$layoutContent = $this->layoutContent($params);
		$viewContent = $this->viewContent($view, $params);
		return str_replace('{{ content }}', $viewContent, $layoutContent);
	}

	public function renderContent($content): string
	{
		$layoutContent = $this->layoutContent();
		return str_replace('{{ content }}', $content, $layoutContent);
	}

	protected function layoutContent($params = []): string
	{
		foreach ($params as $key => $value) {
			$$key = $value;
		}
		ob_start();
		include_once Application::$VIEWS_DIR . '/layouts/' . Controller::STANDARD_LAYOUT . '.php';
		return ob_get_clean();
	}

	protected function viewContent($view, $params = []): string
	{
		foreach ($params as $key => $value) {
			$$key = $value;
		}
		ob_start();
		include_once Application::$VIEWS_DIR . $view . '.php';
		return ob_get_clean();
	}
}
