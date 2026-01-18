<?php

namespace ProductHack\models;

use ProductHack\core\ModelDb;

class UserCodeModel extends ModelDb
{
	public int $id;
	public string $phone;
	public string $code;
	public string $created_at;
	public string $expired_at;

	public function tableName(): string
	{
		return "phone_verification_codes";
	}

	public function attributes(): array
	{
		return ["phone", "code", "created_at", "expired_at"];
	}

	public function rules(): array
	{
		throw new \Exception('Not implemented');
	}
}

class ProductModel extends ModelDb
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
		$imagesModel->create();
		$this->ids_images = $imagesModel->getIdsString();
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
	public function attributes(): array
	{
		return ['name', 'description', 'price', 'stock', 'ids_images'];
	}

	public function tableName(): string
	{
		return "products";
	}
}
