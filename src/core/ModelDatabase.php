<?php

namespace ProductHack\core;

use PDO;
use PDOStatement;

abstract class ModelDatabase extends Model
{
	public readonly string $_table_name;
	public readonly array $_db_properties;

	public function __construct()
	{
		parent::__construct();
		$this->_table_name = $this->getTableName();
		$this->_db_properties = $this->getDatabaseProps();
	}

	public function loadFromWhere(string $prop, mixed $value)
	{
		$result = self::selectWhereEqual($prop, $value);
		if (empty($result))
			return false;
		$this->loadData($result[0]);
		return true;
	}

	public function insert(array $params): bool
	{
		$statement = self::prepare("INSERT INTO $this->_table_name (" . implode(',', $this->_db_properties) . ")
            VALUES(" . implode(',', array_fill(0, count($this->_db_properties), '?')) . ")");
		$success = $statement->execute($params);
		return $success;
	}

	public function changeColumn(string $column_name, $new_value, int $id): bool
	{
		$statement = self::prepare("
				UPDATE $this->_table_name 
				SET $column_name = ? 
				WHERE id = ?
			");
		$success = $statement->execute([$new_value, $id]);
		return $success;
	}
	public function selectAll(): array
	{
		$statement = self::prepare("SELECT * FROM $this->_table_name");
		$statement->execute();
		return $statement->fetchAll(PDO::FETCH_ASSOC);
	}

	public function checkAny(string $columnName, $value): bool
	{
		$statement = self::prepare("
			select exists(
					select 1 from $this->_table_name
					where $columnName = ?
					limit 1
			)
		");
		$statement->execute([$value]);
		return $statement->fetchColumn() === true;
	}

	public function selectWhereEqual($collumnName, $value)
	{
		$statement = self::prepare("SELECT * FROM $this->_table_name WHERE $collumnName = ?");
		$statement->execute([$value]);
		$result = $statement->fetchAll(PDO::FETCH_ASSOC);
		return $result;
	}

	public function selectFirstWhereEqual($collumnName, $value)
	{
		$result = self::selectWhereEqual($collumnName, $value);
		return empty($result) ? null : $result[0];
	}

	public function selectRandom(int $amount): array
	{
		if ($amount < 1) {
			return [];
		}
		$statement = self::prepare("SELECT * FROM $this->_table_name ORDER BY RANDOM() LIMIT ?");
		$statement->execute([$amount]);
		return $statement->fetchAll(PDO::FETCH_ASSOC);
	}

	public function deleteFromId(int $id): bool
	{
		$statement = self::prepare("DELETE FROM $this->_table_name WHERE id = ?");
		$success = $statement->execute([$id]) && $statement->rowCount() > 0;
		return $success;
	}

	public function update(array $attrs, array $params): bool
	{
		$setClause = implode(',', array_map(function ($attr) {
			return "$attr = ?";
		}, $attrs));
		$statement = self::prepare("UPDATE $this->_table_name SET $setClause");
		$success = $statement->execute($params);
		return $success;
	}

	public function lastId(): int
	{
		return Application::$app->database->pdo->lastInsertId();
	}

	public static function prepare($sql): PDOStatement|false
	{
		return Application::$app->database->pdo->prepare($sql);
	}
}
