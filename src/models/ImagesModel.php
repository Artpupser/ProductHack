<?php

namespace ProductHack\models;

use ProductHack\core\ModelDatabase;
use ProductHack\core\ModelDatabaseAttribute;

#[ModelDatabaseAttribute(table_name: "images", table_collumn_names: ["base64", "tag"])]
class ImagesModel extends ModelDatabase
{

	/**
	 * @var array<ImageModel>
	 */
	public array $pool = [];

	public function loadFromTag($tag): void
	{
		$result = $this->selectWhereEqual("tag", $tag);
		foreach ($result as $value) {
			$model = new ImageModel();
			$model->loadData($value);
			array_push($this->pool, $model);
		}
	}

	public function loadAll(): void
	{
		$result = $this->selectAll();
		foreach ($result as $value) {
			$model = new ImageModel();
			$model->loadData($value);
			array_push($this->pool, $model);
		}
	}
	public function getFirst(): ImageModel
	{
		return $this->pool[0];
	}
}