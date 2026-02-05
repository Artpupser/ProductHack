<?php

namespace ProductHack\models;

use ProductHack\core\IterableModel;
use ProductHack\core\ModelDatabaseAttribute;

#[ModelDatabaseAttribute(table_name: "images", table_collumn_names: ["base64", "tag"])]
/**
 * @template-extends IterableModel<ImageModel>
 */
class ImagesModel extends IterableModel
{
	protected function createModel(): ImageModel
	{
		return new ImageModel();
	}
}