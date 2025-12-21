<?php

namespace ProductHack\models;

use ProductHack\core\ModelDb;

class ProductModel extends ModelDb
{
    public int $id;
    public string $name;
    public string $description;
    public float $price;
    public int $stock;
    public $image;
    
    public function create() {

    }

    public function delete() {

    }

    public function change() {

    }

    public function rules() : array 
    {
        return [
            'name' => [self::RULE_IMPORTANT, 
                [self::RULE_MIN, 'min' => 5], 
                [self::RULE_MAX, 'max'=> 150]],
            'description' => [self::RULE_IMPORTANT, 
                [self::RULE_MIN, 'min' => 32], 
                [self::RULE_MAX, 'max'=> 512]],
            'price' => [self::RULE_IMPORTANT, self::RULE_NUMBER],
            'stock' => [self::RULE_IMPORTANT, self::RULE_NUMBER],
            'image' => [self::RULE_IMPORTANT, self::RULE_IMG],
        ];
    }
    public function attributes(): array
    {
        return ['name', 'description', 'price', 'stock', 'image'];
    }

    public function tableName(): string
    {
        return "products";
    }
}