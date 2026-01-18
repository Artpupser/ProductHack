<?php

namespace ProductHack\core;

abstract class Controller
{
	public string $layout = 'workflow';

	public function render($view, $params = [])
	{
		return Application::$app->router->renderView($view, $params);
	}

	public function redirect($location)
	{
		header("Location: $location");
	}
	public function reload()
	{
		header("Location: " . $_SERVER['REQUEST_URI']);
	}

	public function renderJson(Request $request)
	{
		return Application::$app->router->renderContent($request->getDataJson());
	}
}
