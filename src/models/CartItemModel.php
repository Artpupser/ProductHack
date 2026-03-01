<?php

namespace ProductHack\models;

use ProductHack\core\Model;
use ProductHack\core\ModelPropRuleAttribute;
use ProductHack\core\ModelRule;

class CartItemModel extends Model
{
	#[ModelPropRuleAttribute(ModelRule::IMPORTANT)]
	public int $id;
	#[ModelPropRuleAttribute(ModelRule::NUMBER)]
	#[ModelPropRuleAttribute(ModelRule::NUMBER_MIN, 1)]
	#[ModelPropRuleAttribute(ModelRule::NUMBER_MAX, 512)]
	public int $quantity;
	public bool $enable = false;
}
