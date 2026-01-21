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
		$result = $model->get_expired_time(self::get_token());
		$expiredDateTime = new DateTime($result);
		$currentDateTime = new DateTime();
		return $currentDateTime < $expiredDateTime;
	}

	public static function get_session_from_db(): SessionModel|null
	{
		$model = new SessionModel();
		$result = $model->selectWhereEqual("token", self::get_token())[0] ?? null;
		if ($result === null) {
			return $result;
		}
		$model->expires_at = $result["expires_at"];
		$model->token = $result["token"];
		$model->id = $result["id"];
		$model->user_id = $result["user_id"];
		return $model;
	}

	public static function get_user(): UserModel|null
	{
		if (self::verify()) {
			$model = new SessionModel();
			return $model->get_user_from_token(self::get_token());
		}
		return null;
	}
}
