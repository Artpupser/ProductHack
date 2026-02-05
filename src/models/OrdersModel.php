<?php

namespace ProductHack\models;

use ProductHack\core\IterableModel;
use ProductHack\core\ModelDatabase;
use ProductHack\core\ModelDatabaseAttribute;

#[ModelDatabaseAttribute(table_name: "orders", table_collumn_names: [])]
/**
 * @template-extends IterableModel<OrderModel>
 */
class OrdersModel extends IterableModel
{
	public function createModel(): OrderModel
	{
		return new OrderModel();
	}
}