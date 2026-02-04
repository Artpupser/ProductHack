<?php

namespace ProductHack\models;

use ProductHack\core\Model;
use ProductHack\core\ModelPropRuleAttribute;
use ProductHack\core\ModelRule;

class CartModel extends Model
{
	#[ModelPropRuleAttribute(ModelRule::IMPORTANT)]
	public int $id;
	#[ModelPropRuleAttribute(ModelRule::NUMBER)]
	#[ModelPropRuleAttribute(ModelRule::NUMBER_MIN, 1)]
	#[ModelPropRuleAttribute(ModelRule::NUMBER_MAX, 512)]
	public int $cost;

	public function getProducts(): array
	{
		if (!$_SESSION['cart']) {
			return [];
		}
		$products = [];
		foreach ($_SESSION['cart'] as $key => $value) {
			$product = new ProductModel();
			if ($product->loadFromWhere("id", $key)) {
				$products[$key] = $product;
			}
		}
		return $products;
	}
}
