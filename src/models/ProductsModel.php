<?php

namespace ProductHack\models;

use ProductHack\core\IterableModel;
use ProductHack\core\ModelDatabase;
use ProductHack\core\ModelDatabaseAttribute;

/**
 * @template-extends IterableModel<ProductModel>
 */
#[ModelDatabaseAttribute(table_name: "products", table_collumn_names: ['name', 'description', 'price', 'stock'])]
class ProductsModel extends IterableModel
{
	protected function createModel(): ProductModel
	{
		return new ProductModel();
	}
}