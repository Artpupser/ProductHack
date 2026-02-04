<?php

namespace ProductHack\models;

use ProductHack\core\Model;
use ProductHack\core\ModelDatabase;
use ProductHack\core\ModelDatabaseAttribute;
use ProductHack\core\ModelPropRuleAttribute;
use ProductHack\core\ModelRule;

#[ModelDatabaseAttribute(table_name: "images", table_collumn_names: ["base64", "tag"])]
class ImageModel extends ModelDatabase
{
	#[ModelPropRuleAttribute(ModelRule::IMPORTANT)]
	#[ModelPropRuleAttribute(ModelRule::IMG)]
	public string $base64;
	#[ModelPropRuleAttribute(ModelRule::IMPORTANT)]
	#[ModelPropRuleAttribute(ModelRule::TEXT_MAX, 12)]
	public string $tag;
	public int $id;

	public function create(): bool
	{
		$result = $this->insert([$this->base64, $this->tag]);
		if ($result) {
			$this->id = $result;
		}
		return $result;
	}

	public function delete(): bool
	{
		return $this->deleteFromProp("id", $this->id);
	}

}
