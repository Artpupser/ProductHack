<?php

namespace ProductHack\models;

use ProductHack\core\ModelDb;

class SessionModel extends ModelDb
{
	public array $images;


	public function rules(): array
	{
		return [];
	}

	public function attributes_db(): array
	{
		return [''];
	}

	public function tableName(): string
	{
		return "sessions";
	}
}
