<?php

namespace ProductHack\core;

abstract class Model
{

    public const string RULE_EMAIL = 'email';
    public const string RULE_IMPORTANT = 'important';
    public const string RULE_MAX = 'max';
    public const string RULE_MIN = 'min';
    public const string RULE_MAX_NUMBER = 'max_number';
    public const string RULE_MIN_NUMBER = 'min_number';
    public const string RULE_MATCHES = 'matches';
    public const string RULE_NUMBER = 'number';
    public const string RULE_IMG = 'image';

    public array $errors = [];

    public function loadData($data) {
        foreach($data as $key => $value) {
            if(property_exists($this, $key)) {
                $this->{$key} = $value;
            }
        }
    }

    public function validate() {
        foreach($this->rules() as $attribute => $rules) {
            if(!isset($this->{$attribute}))
                continue;
            $value = $this->{$attribute};
            foreach($rules as $rule) {
                $ruleName = $rule;
                if(!is_string($ruleName)) {
                    $ruleName = $rule[0];
                }
                if($ruleName === self::RULE_IMPORTANT && !$value) {
                    $this->addError($attribute, self::RULE_IMPORTANT);
                    continue;
                }
                else if($ruleName === self::RULE_EMAIL && !filter_var($value, FILTER_VALIDATE_EMAIL)) {
                    $this->addError($attribute, self::RULE_EMAIL);
                    continue;
                }
                else if($ruleName === self::RULE_IMG && (!$this->isImageBase64($value))) {
                    $this->addError($attribute, self::RULE_IMG);
                    continue;
                }
                else if($ruleName === self::RULE_NUMBER && !is_numeric($value)) {
                    $this->addError($attribute, self::RULE_NUMBER);
                }
                if($ruleName === self::RULE_MIN && strlen($value) < $rule['min']) {
                    $this->addError($attribute, self::RULE_MIN);
                }
                if($ruleName === self::RULE_MAX && strlen($value) > $rule['max']) {
                    $this->addError($attribute, self::RULE_MAX);
                }
                if($ruleName === self::RULE_MIN_NUMBER && (!is_numeric($value) || !((int)$value < $rule['min_number']))) {
                    $this->addError($attribute, self::RULE_MIN_NUMBER);
                }
                if($ruleName === self::RULE_MAX_NUMBER && (!is_numeric($value) || !((int)$value > $rule['max_number']))) {
                    $this->addError($attribute, self::RULE_MAX_NUMBER);
                }
             }
        }
        return empty($this->errors);
    }

    function isImageBase64($base64String) {
        if (preg_match('/^data:image\/(png|jpeg|jpg|gif);base64,/', $base64String, $matches)) {
            $data = substr($base64String, strlen($matches[0]));
            if (base64_decode($data, true) !== false) {
                $image = @imagecreatefromstring(base64_decode($data));
                if ($image !== false) {
                    return true;
                }
            }
        }
        return false;
    }

    public function addError(string $attribute, string $rule) {
        $message = $this->errorMessages()[$rule] ?? 'Undefiend rule';
        $this->errors[$attribute][] = $message;
    }

    public function errorMessages() {
        return [
            self::RULE_IMPORTANT => 'This field is important',
            self::RULE_MAX => 'This field must not exceed the maximum length',
            self::RULE_MIN => 'This field must be at least the minimum length',
            self::RULE_MAX => 'This field must not exceed the maximum',
            self::RULE_MIN => 'This field must be at least the minimum',
            self::RULE_EMAIL => 'Please enter a valid email address',
            self::RULE_MATCHES => 'This field must match the other field',
            self::RULE_NUMBER => 'This field must be an number',
            self::RULE_IMG => 'This field must be not image', 
        ];
    }

    public function hasError($attribute) {
        return $this->errors[$attribute] ?? false;
    }
    public function firstError($attribute) {
        return $this->errors[$attribute][0] ?? false;
    }

    public abstract function rules() : array;

    protected static function query() // SELECT
    {

    }

    protected static function execute() // NOT SELECT
    {

    }
}