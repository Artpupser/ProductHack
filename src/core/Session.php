<?php

namespace ProductHack\core;

use ProductHack\models\SessionModel;
use ProductHack\models\UserModel;

class Session
{
	public static ?SessionModel $CURRENT = null;
	public static ?UserModel $CURRENT_USER = null;
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
			Session::$CURRENT_USER = Session::$CURRENT->getUser();
			return;
		}
		Session::$CURRENT = null;
	}
}
