<?php

namespace ProductHack\models;

use ProductHack\core\ModelDb;
class LoginModel extends ModelDb
{
	public string $email;
	public string $password;

	public function check(): bool
	{
		$user = $this->selectWhereEqual("email", $this->email);
		return $user[0]["password_hash"] === hash("sha256", $this->password);
	}

	public function rules(): array
	{
		return [
			'email' => [
				self::RULE_IMPORTANT,
				self::RULE_EMAIL,
			],
			'password' => [
				self::RULE_IMPORTANT,
				[self::RULE_MIN, 'min' => 10],
				[self::RULE_MAX, 'max' => 32],
			],
		];
	}

	public function attributes_db(): array
	{
		return ['email', 'password_hash'];
	}

	public function tableName(): string
	{
		return "users";
	}
}
