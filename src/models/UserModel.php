<?php

namespace ProductHack\models;

use ProductHack\core\ModelDb;
class UserModel extends ModelDb
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

	public function rules(): array
	{
		return [];
	}

	public function attributes_db(): array
	{
		return ['email', 'password_hash'];
	}

	public function tableName(): string
	{
		return "users";
	}
}
