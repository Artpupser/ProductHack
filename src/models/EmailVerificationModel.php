<?php

namespace ProductHack\models;

use ProductHack\core\ModelDb;

class EmailVerificationModel extends ModelDb
{
	public int $id;
	public string $email;
	public string $code;
	public string $created_at;
	public string $expired_at;

	public function tableName(): string
	{
		return "email_verification_codes";
	}

	public function attributes_db(): array
	{
		return ["email", "code", "created_at", "expired_at"];
	}

	public function rules(): array
	{
		return [
			'email' => [
				self::RULE_IMPORTANT,
				self::RULE_EMAIL,
			],
			'code' => [
				self::RULE_IMPORTANT,
				[self::RULE_MIN, 'min' => 6],
			],
		];
	}
}
