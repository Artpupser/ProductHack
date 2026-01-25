<?php

namespace ProductHack\controllers;

use ProductHack\core\Application;
use ProductHack\core\Controller;
use ProductHack\core\Request;

class FileController extends Controller
{

	public function __construct()
	{

	}

	public function getMimeType(string $path): string
	{
		$extension = pathinfo($path, PATHINFO_EXTENSION);
		$mime = [
			'css' => 'text/css',
			'js' => 'application/javascript',
			'webp' => 'image/webp',
			'woff2' => 'font/woff2',
		];
		return $mime[$extension];
	}

	public function file(Request $request)
	{
		$path = Application::$ROOT_DIR . "/public/" . $request->getData()['name'];
		//echo $path;
		if (file_exists($path)) {
			header('Content-Type: ' . $this->getMimeType($path));
			header('Content-Disposition: attachment; filename="' . basename($path) . '"');
			header('Content-Length: ' . filesize($path));
			readfile($path, false);
			exit;
		} else {
			Application::$app->error->pushServerError(404, "File not found");
		}

	}

}
