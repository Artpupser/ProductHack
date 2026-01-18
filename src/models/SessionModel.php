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
		if ($userModel !== null) {
			return $this->insert([$userModel->id, Session::get_token(), date('Y-m-d', strtotime('+1 day'))]);
		}
		return false;
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
