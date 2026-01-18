<?php

namespace ProductHack\models;

use DateTime;
use ProductHack\core\ModelDb;
use ProductHack\core\Session;

class SessionModel extends ModelDb
{
	public int $id;
	public int $user_id;
	public string $token;
	public string $expires_at;

	public function create(string $email): bool
	{
		$userModel = UserModel::get_user_from_email($email);
		$currentSession = Session::get_session_from_db();
		if ($currentSession == null) {
			if ($userModel !== null) {
				return $this->insert([$userModel->id, Session::get_token(), self::current_time_plus_days(1)]);
			}
		} else {
			$currentSession->changeColumn("expires_at", self::current_time_plus_days(1), $currentSession->id);
		}
		return false;
	}
	public static function current_time_plus_days(int $days): string
	{
		return date('Y-m-d', strtotime("+$days day"));
	}

	public function get_user_from_token(string $token): UserModel|null
	{
		$result = $this->selectWhereEqual("token", $token);
		if (!empty($result)) {
			return UserModel::get_user_from_id($result[0]["user_id"]);
		}
		return null;
	}

	public function get_expired_time(string $token): string|null
	{
		$result = $this->selectWhereEqual("token", $token)[0];
		if (isset($result["expires_at"])) {
			return $result["expires_at"];
		}
		return null;
	}

	public function rules(): array
	{
		return [];
	}

	public function attributes_db(): array
	{
		return ['user_id', 'token', 'expires_at'];
	}

	public function tableName(): string
	{
		return "sessions";
	}
}
