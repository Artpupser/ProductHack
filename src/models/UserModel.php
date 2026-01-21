<?php

namespace ProductHack\models;

use ProductHack\core\ModelDatabase;
use ProductHack\core\ModelDatabaseAttribute;
use ProductHack\core\ModelPropDatabaseAttribute;

#[ModelDatabaseAttribute(table_name: "users", table_collumn_names: ["email", "password_hash"])]
class UserModel extends ModelDatabase
{
	public int $id;
	public string $email;
	public string $password_hash;
	public string|null $full_name;
	public int $role_id;
	public static function get_user_from_email(string $email): UserModel|null
	{
		$model = new UserModel();
		$result = $model->selectWhereEqual("email", $email)[0];
		if (!empty($result)) {
			$model->email = $result["email"];
			$model->password_hash = $result["password_hash"];
			$model->id = $result["id"];
			$model->full_name = $result["full_name"];
			$model->role_id = $result["role_id"];
			return $model;
		}
		return null;
	}

	public static function get_user_from_id(int $id): UserModel|null
	{
		$model = new UserModel();
		$result = $model->selectWhereEqual("id", $id)[0];
		if (!empty($result)) {
			$model->email = $result["email"];
			$model->password_hash = $result["password_hash"];
			$model->id = $result["id"];
			$model->full_name = $result["full_name"];
			$model->role_id = $result["role_id"];
			return $model;
		}
		return null;
	}
}
