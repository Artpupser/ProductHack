<?php

namespace ProductHack\models;

use ProductHack\core\ModelDb;

class RegistrationModel extends ModelDb
{
	public string $email;
	public string $password;
	public string $repeat_password;
	public int $role_id;

	public function create() : bool {
		return $this->insert([$this->email, hash("sha256", $this->password), 1]);
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
			'repeat_password' => [
				self::RULE_IMPORTANT,
				[self::RULE_MIN, 'min' => 10],
				[self::RULE_MAX, 'max' => 32],
				[self::RULE_MATCHES, 'match_name' => 'password'],
			],
		];
	}

	public function attributes_db(): array
	{
		return ['email', 'password_hash', 'role_id'];
	}

	public function tableName(): string
	{
		return "users";
	}
}
