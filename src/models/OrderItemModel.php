<?php

namespace ProductHack\models;

use ProductHack\core\ModelDatabase;
use ProductHack\core\ModelDatabaseAttribute;
use ProductHack\core\ModelPropRuleAttribute;
use ProductHack\core\ModelRule;

#[ModelDatabaseAttribute(table_name: "order_items", table_collumn_names: ["order_id", "product_id", "amount", "price_snapshot"])]
class OrderItemModel extends ModelDatabase
{
	public int $id;
	#[ModelPropRuleAttribute(ModelRule::NUMBER)]
	public int $order_id;
	#[ModelPropRuleAttribute(ModelRule::NUMBER)]
	public int $product_id;
	#[ModelPropRuleAttribute(ModelRule::NUMBER)]
	#[ModelPropRuleAttribute(ModelRule::NUMBER_MIN, 1)]
	#[ModelPropRuleAttribute(ModelRule::NUMBER_MAX, 128)]
	public int $amount;
	#[ModelPropRuleAttribute(ModelRule::NUMBER_MIN, 1)]
	public int $price_snapshot;
	public function create()
	{
		return $this->insert([$this->order_id, $this->product_id, $this->amount, $this->price_snapshot]);
	}

	public function product(): ProductModel
	{
		$model = new ProductModel();
		$model->loadFromWhere("id", $this->product_id);
		return $model;
	}
}
