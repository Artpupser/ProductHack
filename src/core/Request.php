<?php

namespace ProductHack\core;

class Request
{

	public function __construct() {}

	public function getPath()
	{
		$path = $_SERVER['REQUEST_URI'] ?? '/';
		$position = strpos($path, '?');
		if ($position === false) {
			return $path;
		}
		return substr($path, 0, $position);
	}

	public function getMethod()
	{
		return strtolower($_SERVER['REQUEST_METHOD']);
	}

	public function isGet()
	{
		return $this->getMethod() === "get";
	}
	public function isPost()
	{
		return $this->getMethod() === "post";
	}

	public function getContent()
	{
		$body = [];
		if ($this->isGet()) {
			foreach ($_GET as $key => $value) {
				$body[$key] = filter_input(INPUT_GET, $key, FILTER_SANITIZE_SPECIAL_CHARS);
			}
		} else if ($this->isPost()) {
			foreach ($_POST as $key => $value) {
				$body[$key] = filter_input(INPUT_POST, $key, FILTER_SANITIZE_SPECIAL_CHARS);
			}
			foreach ($_FILES as $fileKey => $file) {
				if ($file['error'] === UPLOAD_ERR_OK) {
					$imageData = base64_encode(file_get_contents($file['tmp_name']));
					$body['images'][$fileKey] = 'data:' . $file['type'] . ';base64,' . $imageData;
				}
			}
		}
		return $body;
	}

	public function getContentJson()
	{
		return json_encode($this->getContent());
	}
}
