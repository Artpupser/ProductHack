<?php

namespace ProductHack\core;

abstract class Controller
{
	public const string STANDARD_LAYOUT = 'workflow';
	public const string EMPTY_LAYOUT = 'empty_workflow';
	public string $layout = self::STANDARD_LAYOUT;

	public function renderPage($view, $params = [])
	{
		$params["pageTitle"] = "Винный магазин";
		$params["clientErrors"] = Application::$app->error->getClientErrors();
		return Application::$app->router->renderView($view, $params);
	}

	public function redirect($location)
	{
		header("Location: /$location");
	}

	public function reload()
	{
		header("Location: " . $_SERVER['REQUEST_URI']);
	}

	public function renderDump(mixed $data)
	{
		return Application::$app->router->renderContent(var_dump($data));
	}

	public function renderJson(mixed $data)
	{
		header('Content-Type: application/json; charset=utf-8');
		echo json_encode($data, JSON_UNESCAPED_UNICODE);
	}
}
