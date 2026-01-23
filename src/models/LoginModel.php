<?php

namespace ProductHack\models;

use ProductHack\core\ModelDatabaseAttribute;
use ProductHack\core\ModelDatabase;
use ProductHack\core\ModelPropDatabaseAttribute;
use ProductHack\core\ModelPropRuleAttribute;
use ProductHack\core\ModelRule;

#[ModelDatabaseAttribute(table_name: "users", table_collumn_names: ["email", "password"])]
class LoginModel extends UserModel
{
	#[ModelPropRuleAttribute(ModelRule::IMPORTANT)]
	#[ModelPropRuleAttribute(ModelRule::EMAIL)]
	public string $email;
	#[ModelPropRuleAttribute(ModelRule::TEXT_MIN, 10)]
	#[ModelPropRuleAttribute(ModelRule::TEXT_MAX, 256)]
	public string $password;
	public string $password_hash { get => hash('sha256', $this->password); }

	public function enter(): bool
	{
		$user = new UserModel();
		return $user->loadFromWhere("email", $this->email) && $user->password_hash === $this->password_hash;
	}

	public function getUser(): ?UserModel
	{
		parent::loadFromWhere("email", $this->email);
		return $this;
	}

}
