<?php

namespace ProductHack\core;

use PDO;
use PDOStatement;

abstract class ModelDatabase extends Model
{
	public readonly string $tableName;
	public readonly array $dbProperties;

	public function __construct()
	{
		parent::__construct();
		$this->tableName = $this->getTableName();
		$this->dbProperties = $this->getDatabaseProps();
	}

	public function loadFromWhere(string $prop, mixed $value)
	{
		$result = self::selectWhereEqual($prop, $value);
		if (empty($result))
			return false;
		$this->loadData($result[0]);
		return true;
	}

	public function insert(array $params): false|string
	{
		$statement = self::prepare("INSERT INTO $this->tableName (" . implode(',', $this->dbProperties) . ")
            VALUES(" . implode(',', array_fill(0, \count($this->dbProperties), '?')) . ")");
		$success = $statement->execute($params);
		if ($success) {
			return $this->lastId();
		}
		return $success;
	}

	public function insertWithCustomProps(array $params, array $props): false|string
	{
		$statement = self::prepare("INSERT INTO $this->tableName (" . implode(',', $props) . ")
            VALUES(" . implode(',', array_fill(0, \count($props), '?')) . ")");
		$success = $statement->execute($params);
		if ($success) {
			return $this->lastId();
		}
		return $success;
	}


	public function changeColumn(string $column_name, $new_value, int $id): bool
	{
		$statement = self::prepare("
				UPDATE $this->tableName 
				SET $column_name = ? 
				WHERE id = ?
			");
		$success = $statement->execute([$new_value, $id]);
		return $success;
	}
	public function selectAll(): array
	{
		$statement = self::prepare("SELECT * FROM $this->tableName");
		$statement->execute();
		return $statement->fetchAll(PDO::FETCH_ASSOC);
	}

	public function checkAny(string $columnName, $value): bool
	{
		$statement = self::prepare("
			select exists(
					select 1 from $this->tableName
					where $columnName = ?
					limit 1
			)
		");
		$statement->execute([$value]);
		return $statement->fetchColumn() === true;
	}

	public function selectWhereEqual($collumnName, $value)
	{
		$statement = self::prepare("SELECT * FROM $this->tableName WHERE $collumnName = ?");
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
		$statement = self::prepare("SELECT * FROM $this->tableName ORDER BY RANDOM() LIMIT ?");
		$statement->execute([$amount]);
		return $statement->fetchAll(PDO::FETCH_ASSOC);
	}

	public function deleteFromProp($collumnName, mixed $value): bool
	{
		$statement = self::prepare("DELETE FROM $this->tableName WHERE $collumnName = ?");
		$success = $statement->execute([$value]) && $statement->rowCount() > 0;
		return $success;
	}

	public function update(array $attrs, array $params): bool
	{
		$setClause = implode(',', array_map(function ($attr) {
			return "$attr = ?";
		}, $attrs));
		$statement = self::prepare("UPDATE $this->tableName SET $setClause");
		$success = $statement->execute($params);
		return $success;
	}

	public function lastId(): int
	{
		return Application::$app->database->pdo->lastInsertId();
	}

	public function freeId(): int
	{
		$stmt = Application::$app->database->pdo->query(" SELECT COALESCE((SELECT MAX(id) FROM $this->tableName), 0) + 1 AS free_id");
		return $stmt->fetchColumn();
	}

	public static function prepare($sql): PDOStatement|false
	{
		return Application::$app->database->pdo->prepare($sql);
	}
}
