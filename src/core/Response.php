<?php

namespace ProductHack\core;

class Response
{
	public function __construct()
	{
	}

	public static function setStatusCode(int $code)
	{
		http_response_code($code);
	}

	public static function getStatusCode(): int
	{
		return http_response_code();
	}
}
