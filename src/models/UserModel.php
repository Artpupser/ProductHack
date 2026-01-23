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
}
