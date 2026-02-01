<?php

namespace ProductHack\core;

use ProductHack\models\SessionModel;

class Session
{
	public static ?SessionModel $CURRENT = null;
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
		return Session::$CURRENT == null;
	}

	public static function load()
	{
		$model = new SessionModel();
		if ($model->loadFromPHPSESSID() && $model->inDate) {
			Session::$CURRENT = $model;
			return;
		}
		Session::$CURRENT = null;
	}
}
