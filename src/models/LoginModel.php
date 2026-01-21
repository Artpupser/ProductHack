<?php

namespace ProductHack\models;

use ProductHack\core\ModelDatabaseAttribute;
use ProductHack\core\ModelDatabase;
use ProductHack\core\ModelPropDatabaseAttribute;
use ProductHack\core\ModelPropRuleAttribute;
use ProductHack\core\ModelRule;

#[ModelDatabaseAttribute(table_name: "users", table_collumn_names: ["email", "password"])]
class LoginModel extends ModelDatabase
{
	#[ModelPropRuleAttribute(ModelRule::IMPORTANT)]
	#[ModelPropRuleAttribute(ModelRule::EMAIL)]
	public string $email;
	#[ModelPropRuleAttribute(ModelRule::TEXT_MIN, 10)]
	#[ModelPropRuleAttribute(ModelRule::TEXT_MAX, 32)]
	public string $password;

	public function check(): bool
	{
		$user = $this->selectWhereEqual("email", $this->email);
		return $user[0]["password_hash"] === hash("sha256", $this->password);
	}

}
