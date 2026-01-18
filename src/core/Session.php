<?php

namespace ProductHack\core;

use DateTime;
use ProductHack\models\SessionModel;
use ProductHack\models\UserModel;

class Session
{
	public function __construct()
	{
		session_start();
	}

	public static function session(): array
	{
		return $_SESSION;
	}
	public static function get_token(): string
	{
		return $_COOKIE["PHPSESSID"];
	}
	public static function verify(): bool
	{
		$model = new SessionModel();
		$expiredDateTime = new DateTime($model->get_expired_time(self::get_token()));
		$currentDateTime = new DateTime();
		return $currentDateTime < $expiredDateTime;
	}

	public static function get_user(): UserModel|null
	{
		if (self::verify()) {
			$model = new SessionModel();
			return $model->get_user_from_token(self::get_token());
		}
		return null;
	}

	public static function is_role(string $role): bool
	{
		return false;
	}

	public static function create_new_session()
	{

	}

	public function load_session()
	{

	}
}
