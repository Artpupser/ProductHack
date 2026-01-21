<?php

namespace ProductHack\models;

use ProductHack\core\ModelDatabase;
use ProductHack\core\ModelDatabaseAttribute;
use ProductHack\core\ModelPropRuleAttribute;
use ProductHack\core\ModelRule;

#[ModelDatabaseAttribute(table_name: "images", table_collumn_names: ["base64", "tag"])]
class ImagesModel extends ModelDatabase
{
	#[ModelPropRuleAttribute(ModelRule::IMPORTANT)]
	#[ModelPropRuleAttribute(ModelRule::IMG)]
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
}
