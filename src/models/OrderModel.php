<?php

namespace ProductHack\models;

use DateTimeImmutable;
use ProductHack\core\Application;
use ProductHack\core\ModelDatabase;
use ProductHack\core\ModelDatabaseAttribute;
use ProductHack\core\Session;

enum OrderStatus: int
{
	case CANCEL = 1;
	case CREATED = 2;
	case PROCESS = 3;
	case COMPLETED = 4;
}

#[ModelDatabaseAttribute(table_name: "orders", table_collumn_names: [])]
class OrderModel extends ModelDatabase
{
	public int $id;
	public int $user_id;
	public int $status_id;
	public string $created_at;
	public string $updated_at;
	public int $total_price;
	public OrderStatus $status { get => OrderStatus::from($this->status_id); }
	public DateTimeImmutable $created_at_dateTime { get => new DateTimeImmutable($this->created_at); }
	public DateTimeImmutable $updated_at_dateTime { get => new DateTimeImmutable($this->updated_at); }
	public function initOrder()
	{
		$cart = new CartModel();
		$cart->loadCart();
		$this->status_id = OrderStatus::CREATED->value;
		$this->total_price = $cart->total();
		$this->user_id = Session::$CURRENT->user_id;
		$this->id = $this->freeId();
	}
	/**
	 * @return array<OrderItemModel>
	 */
	public function getOrderItemModels(): array
	{
		$items = [];
		$orderItemModel = new OrderItemModel();
		foreach ($orderItemModel->selectWhereEqual("order_id", $this->id) as $key => $value) {
			$model = new OrderItemModel();
			$model->loadData($value);
			$items[] = $model;
		}
		return $items;
	}
	public function create(): bool
	{
		$cart = new CartModel();
		$cart->loadCart();
		if (!$this->insertWithCustomProps([$this->user_id, $this->total_price, $this->status_id], ["user_id", "total_price", "status_id"])) {
			return false;
		}
		$this->id = $this->lastId();
		$result = $cart->enumerate(function (ProductModel $product, CartItemModel $cartItemModel) {
			if (!$cartItemModel->enable) {
				return true;
			}
			$orderItem = new OrderItemModel();
			$orderItem->amount = $cartItemModel->cost;
			$orderItem->price_snapshot = $product->price * $cartItemModel->cost;
			$orderItem->product_id = $product->id;
			$orderItem->order_id = $this->id;
			if ($orderItem->validate()) {
				if (!$orderItem->create()) {
					Application::$app->error->pushClientError("any", "OrederItem bad created");
					return false;
				}
			}
			return true;
		});
		if (!$result) {
			$orderItem = new OrderItemModel();
			if (!$orderItem->deleteFromProp("order_id", $this->id)) {
				Application::$app->error->pushServerError(400, "OrderItem failed remove");
			}
			if (!$this->deleteFromProp("id", $this->id)) {
				Application::$app->error->pushServerError(400, "Order failed remove");
			}
			return false;
		}
		return true;
	}
}
