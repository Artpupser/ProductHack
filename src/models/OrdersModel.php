<?php

namespace ProductHack\models;

use ProductHack\core\ModelDatabase;
use ProductHack\core\ModelDatabaseAttribute;

#[ModelDatabaseAttribute(table_name: "orders", table_collumn_names: [])]
class OrdersModel extends ModelDatabase
{

	/**
	 * @var array<OrderModel>
	 */
	public array $pool = [];

	public function loadAll(): void
	{
		$result = $this->selectAll();
		foreach ($result as $value) {
			$model = new OrderModel();
			$model->loadData($value);
			array_push($this->pool, $model);
		}
	}

	public function getFirst(): OrderModel
	{
		return $this->pool[0];
	}
}