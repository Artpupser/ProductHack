<?php

namespace ProductHack\models;

use ProductHack\core\ModelDatabase;
use ProductHack\core\ModelDatabaseAttribute;
use ProductHack\core\ModelPropDatabaseAttribute;
use ProductHack\core\ModelPropRuleAttribute;
use ProductHack\core\ModelRule;

#[ModelDatabaseAttribute(table_name: "users", table_collumn_names: ["email", "password_hash", "role_id"])]
class RegistrationModel extends ModelDatabase
{
	#[ModelPropRuleAttribute(ModelRule::IMPORTANT)]
	#[ModelPropRuleAttribute(ModelRule::EMAIL)]
	public string $email;
	#[ModelPropRuleAttribute(ModelRule::IMPORTANT)]
	#[ModelPropRuleAttribute(ModelRule::TEXT_MIN, 10)]
	#[ModelPropRuleAttribute(ModelRule::TEXT_MAX, 32)]
	public string $password;
	#[ModelPropRuleAttribute(ModelRule::IMPORTANT)]
	#[ModelPropRuleAttribute(ModelRule::TEXT_MIN, 10)]
	#[ModelPropRuleAttribute(ModelRule::TEXT_MAX, 32)]
	#[ModelPropRuleAttribute(ModelRule::MATCH , "password")]
	public string $repeat_password;
	public int $role_id;

	public function create(): bool
	{
		return $this->insert([$this->email, hash("sha256", $this->password), 1]);
	}
}
