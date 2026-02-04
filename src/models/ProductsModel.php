<?php

namespace ProductHack\models;

use ProductHack\core\ModelDatabase;

use ProductHack\core\ModelDatabaseAttribute;

#[ModelDatabaseAttribute(table_name: "products", table_collumn_names: ['name', 'description', 'price', 'stock'])]
class ProductsModel extends ModelDatabase
{
	/**
	 * @var array<ProductModel>
	 */
	public array $pool = [];

	public function loadAll(): void
	{
		$result = $this->selectAll();
		foreach ($result as $value) {
			$model = new ProductModel();
			$model->loadData($value);
			array_push($this->pool, $model);
		}
	}

	public function getFirst(): ProductModel
	{
		return $this->pool[0];
	}

}