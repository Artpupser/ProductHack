<?php

namespace ProductHack\models;

use DateTime;
use DateTimeImmutable;
use ProductHack\core\ModelDatabase;
use ProductHack\core\ModelDatabaseAttribute;
use ProductHack\core\ModelPropDatabaseAttribute;
use ProductHack\core\Session;

#[ModelDatabaseAttribute(table_name: "sessions", table_collumn_names: ["user_id", "token", "expires_at"])]
class SessionModel extends ModelDatabase
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
				return $this->insert([$userModel->id, Session::get_token(), self::current_time_plus_days(2)]);
			}
		} else {
			$result = $currentSession->changeColumn("expires_at", self::current_time_plus_days(2), $currentSession->id);
		}
		return false;
	}
	public static function current_time_plus_days(int $days): string
	{
		return (new DateTimeImmutable())->modify('+' . $days . 'day')->format('Y-m-d H:i:s');
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
		$result = $this->selectWhereEqual("token", $token);
		if (empty($result)) {
			return null;
		}
		return $result[0]["expires_at"];
	}

}
