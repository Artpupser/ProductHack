<?php

namespace ProductHack\core;

use ProductHack\models\SessionModel;

class Session
{
	public function __construct()
	{
		session_start();
	}
	public static function token(): string
	{
		return $_COOKIE["PHPSESSID"] ?? "";
	}

	public static function session(): array
	{
		return $_SESSION;
	}

	public static function verify(): bool
	{
		$model = new SessionModel();
		return $model->loadFromPHPSESSID() && $model->inDate;
	}
}
