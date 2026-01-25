<?php

namespace ProductHack\models;

use ProductHack\core\ModelDatabase;
use ProductHack\core\ModelDatabaseAttribute;
use ProductHack\core\ModelPropRuleAttribute;
use ProductHack\core\ModelRule;

#[ModelDatabaseAttribute(table_name: "email_verification_codes", table_collumn_names: ["email", "code", "created_at", "expired_at"])]
class EmailVerificationModel extends ModelDatabase
{
	public int $id;
	#[ModelPropRuleAttribute(ModelRule::IMPORTANT)]
	#[ModelPropRuleAttribute(ModelRule::EMAIL)]
	public string $email;
	#[ModelPropRuleAttribute(ModelRule::IMPORTANT)]
	#[ModelPropRuleAttribute(ModelRule::TEXT_MIN, 6)]
	#[ModelPropRuleAttribute(ModelRule::TEXT_MAX, 6)]
	public string $code;
	public string $created_at;
	public string $expired_at;
}
