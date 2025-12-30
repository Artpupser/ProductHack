<?php

namespace ProductHack\core;

use PDO;
use PDOStatement;

abstract class ModelDb extends Model
{
    public abstract function tableName(): string;
    public abstract function attributes(): array;

    public function insert(array $params) : bool
    {
        $tableName = $this->tableName();
        $attrs = $this->attributes();
        $statement = self::prepare("INSERT INTO $tableName (".implode(',', $attrs).")
            VALUES(".implode(',', array_fill(0, count($attrs), '?')).")");
        $success = $statement->execute($params);
        return $success;
    }

    public function selectAll() : array
    {
        $tableName = $this->tableName();
        $statement = self::prepare("SELECT * FROM $tableName");
        $statement->execute();
        return $statement->fetchAll(PDO::FETCH_ASSOC);
    }

    public function selectWhereEqual($collumnName, $value) {
        $tableName = $this->tableName();
        $statement = self::prepare("SELECT * FROM $tableName WHERE $collumnName = ?");
        $statement->execute([$value]);
        return $statement->fetchAll(PDO::FETCH_ASSOC);
    }

    public function selectRandom(int $amount) : array {
        $tableName = $this->tableName();
        if ($amount < 1) {
            return [];
        }
        $statement = self::prepare("SELECT * FROM $tableName ORDER BY RANDOM() LIMIT ?");
        $statement->execute([$amount]);
        return $statement->fetchAll(PDO::FETCH_ASSOC);
    }

    public function deleteFromId(int $id) : bool
    {
        $tableName = $this->tableName();
        $statement = self::prepare("DELETE FROM $tableName WHERE id = ?");
        $success = $statement->execute([$id]) && $statement->rowCount() > 0;
        return $success;
    }

    public function update(array $attrs, array $params) : bool
    {
        $tableName = $this->tableName();
        $setClause = implode(',', array_map(function($attr) { return "$attr = ?"; }, $attrs));
        $statement = self::prepare("UPDATE $tableName SET $setClause");
        $success = $statement->execute($params);
        return $success;
    }

    public function lastId() : int {
        return Application::$app->database->pdo->lastInsertId();
    }


    public static function prepare($sql) : PDOStatement|false {
        return Application::$app->database->pdo->prepare($sql);
    }
}