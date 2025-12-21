<?php

namespace ProductHack\core;

abstract class ModelDb extends Model
{
    public abstract function tableName(): string;
    public abstract function attributes(): array;

    public function insert()
    {
        $tableName = $this->tableName();
        $attrs = $this->attributes();
        $params = array_map(fn($a) => ":$a", $attrs);
        $statement = self::prepare("INSERT INTO $tableName (".implode(',', $attrs).")
            VALUES(".implode(',', $params).")");
        echo var_dump($statement, $params, $attrs);
    }

    public static function prepare($sql) {
        return Application::$app->database->pdo->prepare($sql);
    }
}