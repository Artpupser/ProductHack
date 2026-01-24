<?php

namespace ProductHack\models;

use ProductHack\core\ModelDatabase;

use ProductHack\core\ModelDatabaseAttribute;
use ProductHack\core\ModelPropRuleAttribute;
use ProductHack\core\ModelRule;

#[ModelDatabaseAttribute(table_name: "products", table_collumn_names: ['name', 'description', 'price', 'stock', 'ids_images'])]
class ProductModel extends ModelDatabase
{
	public int $id;
	#[ModelPropRuleAttribute(ModelRule::IMPORTANT)]
	#[ModelPropRuleAttribute(ModelRule::TEXT_MIN, 8)]
	#[ModelPropRuleAttribute(ModelRule::TEXT_MAX, 128)]
	public string $name;
	#[ModelPropRuleAttribute(ModelRule::IMPORTANT)]
	#[ModelPropRuleAttribute(ModelRule::TEXT_MIN, 8)]
	#[ModelPropRuleAttribute(ModelRule::TEXT_MAX, 512)]

	public string $description;
	#[ModelPropRuleAttribute(ModelRule::IMPORTANT)]
	#[ModelPropRuleAttribute(ModelRule::NUMBER)]
	#[ModelPropRuleAttribute(ModelRule::NUMBER_MIN, 1)]
	#[ModelPropRuleAttribute(ModelRule::NUMBER_MAX, 10 ** 6)]
	public float $price;
	#[ModelPropRuleAttribute(ModelRule::IMPORTANT)]
	#[ModelPropRuleAttribute(ModelRule::NUMBER)]
	#[ModelPropRuleAttribute(ModelRule::NUMBER_MAX, 1024)]
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
		return $this->deleteFromProp("id", $id);
	}

	public function change(array $attrs, array $params): bool
	{
		return $this->update($attrs, $params);
	}

}