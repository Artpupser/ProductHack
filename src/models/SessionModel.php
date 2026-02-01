<?php

namespace ProductHack\models;

use DateTimeImmutable;
use ProductHack\core\ModelDatabase;
use ProductHack\core\ModelDatabaseAttribute;
use ProductHack\core\Session;

#[ModelDatabaseAttribute(table_name: "sessions", table_collumn_names: ["user_id", "token", "expires_at"])]
class SessionModel extends ModelDatabase
{
	public int $id;
	public int $user_id;
	public string $token;
	public string $created_at;
	public string $expires_at;
	public DateTimeImmutable $expires_at_dateTime { get => new DateTimeImmutable($this->expires_at); }
	public bool $inDate { get => new DateTimeImmutable('now') < $this->expires_at_dateTime; }
	public function create(LoginModel $loginModel): bool
	{
		if (!$this->loadFromPHPSESSID()) {
			$user = $loginModel->getUser();
			if ($user !== null)
				return $this->insert([$user->id, Session::token(), self::nextSessionTime()]);
			return false;
		}
		return $this->extendSessionTime();
	}

	public function loadFromPHPSESSID()
	{
		return $this->loadFromWhere("token", Session::token());
	}

	public function extendSessionTime(): bool
	{
		return $this->changeColumn("expires_at", self::nextSessionTime(), $this->id);
	}

	public static function nextSessionTime(): string
	{
		return new DateTimeImmutable("tomorrow")->format('Y-m-d H:i:s');
	}

	public function getUser(): UserModel|null
	{
		$user = new UserModel();
		$user->loadFromWhere("id", $this->user_id);
		return $user;
	}
}
