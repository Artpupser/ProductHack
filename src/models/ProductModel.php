<?php

namespace ProductHack\models;

use ProductHack\core\ModelDatabase;

use ProductHack\core\ModelDatabaseAttribute;

#[ModelDatabaseAttribute(table_name: "products")]
class ProductModel extends ModelDatabase
{
	public int $id;
	public string $name;
	public string $description;
	public float $price;
	public int $stock;
	public array $images;
	public string $ids_images;

	public function create(): bool
	{
		$imagesModel = new ImagesModel();
		$imagesModel->images = $this->images;
		$imagesModel->tag = "product";
		$imagesModel->create();
		$this->ids_images = $imagesModel->getLastIdsString();
		return $this->insert([$this->name, $this->description, $this->price, $this->stock, $this->ids_images]);
	}

	public function delete(int $id): bool
	{
		return $this->deleteFromId($id);
	}

	public function change(array $attrs, array $params): bool
	{
		return $this->update($attrs, $params);
	}

	public function rules(): array
	{
		return [
			'name' => [
				self::RULE_IMPORTANT,
				[self::RULE_MIN, 'min' => 5],
				[self::RULE_MAX, 'max' => 150]
			],
			'description' => [
				self::RULE_IMPORTANT,
				[self::RULE_MIN, 'min' => 32],
				[self::RULE_MAX, 'max' => 512]
			],
			'price' => [self::RULE_IMPORTANT, self::RULE_NUMBER],
			'stock' => [self::RULE_IMPORTANT, self::RULE_NUMBER],
		];
	}
	public function attributes_db(): array
	{
		return ['name', 'description', 'price', 'stock', 'ids_images'];
	}

}