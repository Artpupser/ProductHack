<?php

namespace ProductHack\models;

use ProductHack\core\Model;

class CartModel extends Model
{
	/**
	 * @var array<ProductModel>
	 */
	public array $products;
	/**
	 * @var array<CartItemModel>
	 */
	public bool $isCorrect { get => isset($_SESSION['caart']); }
	public ?array $cartItems { get => $_SESSION['cart']; }
	public function loadCart()
	{
		if (!$this->cartItems) {
			return [];
		}
		foreach ($this->cartItems as $key => $value) {
			$product = new ProductModel();
			if ($product->loadFromWhere("id", $key)) {
				$this->products[$key] = $product;
			}
		}
	}

	public function enumerate(callable $callback): bool
	{
		foreach ($this->cartItems as $key => $value) {
			if (!$callback($this->products[$key], $value, $key)) {
				return false;
			}
		}
		return true;
	}

	public function priceProduct(string $id)
	{
		return $this->products[$id]->price * $this->cartItems[$id]->quantity;
	}

	public function total()
	{
		$amount = 0;
		foreach ($this->cartItems as $key => $value) {
			if (!$value->enable) {
				continue;
			}
			$amount += $this->priceProduct($key);
		}
		return $amount;
	}
}
