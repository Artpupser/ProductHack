<?php

namespace ProductHack\core;

class Response
{
	public function __construct() {}

	public function setStatusCode(int $code)
	{
		http_response_code($code);
	}
	public function getStatusCode(): int
	{
		return http_response_code();
	}
}
