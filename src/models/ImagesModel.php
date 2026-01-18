<?php

namespace ProductHack\models;

use ProductHack\core\ModelDb;

class ImagesModel extends ModelDb
{
	public array $images;
	public array $last_ids = [];
	public string $tag;

	public function getLastIdsString(): string
	{
		return implode(',', $this->last_ids);
	}


	public function create()
	{
		foreach ($this->images as $key => $value) {
			$this->insert([$value, $this->tag]);
			array_push($this->last_ids, $this->lastId());
		}
	}

	public function rules(): array
	{
		return [
			'images' => [self::RULE_IMPORTANT, self::RULE_IMG],
		];
	}

	public function attributes_db(): array
	{
		return ['base64', 'tag'];
	}

	public function tableName(): string
	{
		return "images";
	}
}
