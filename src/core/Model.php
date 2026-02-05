<?php

namespace ProductHack\core;

use Attribute;
use ReflectionClass;
use ReflectionProperty;

#[Attribute(flags: Attribute::TARGET_PROPERTY | Attribute::IS_REPEATABLE)]
class ModelPropRuleAttribute
{
	public function __construct(public ModelRule $rule, public string|int|null $value = null)
	{
	}
}


#[Attribute(flags: Attribute::TARGET_CLASS)]
class ModelDatabaseAttribute
{
	public function __construct(public string $table_name, public array $table_collumn_names = [])
	{
	}
}


enum ModelRule: int
{
	case IMPORTANT = 0;
	case EMAIL = 1;
	case TEXT_MAX = 2;
	case TEXT_MIN = 3;
	case NUMBER_MAX = 4;
	case NUMBER_MIN = 5;
	case MATCH = 6;
	case NUMBER = 7;
	case IMG = 8;

	public function message(mixed $value): string
	{
		return match ($this) {
			self::IMPORTANT => '⚠️ Поле обязательно для заполнения',
			self::TEXT_MAX => "📏 Максимальная длина: {$value} символов",
			self::TEXT_MIN => "📏 Минимальная длина: {$value} символов",
			self::NUMBER_MAX => "🔢 Максимальное значение: {$value}",
			self::NUMBER_MIN => "🔢 Минимальное значение: {$value}",
			self::EMAIL => '✉️ Неверный формат email адреса',
			self::MATCH => '🔗 Поля не совпадают',
			self::NUMBER => '🔢 Значение должно быть числом',
			self::IMG => '🖼️ Файл должен быть изображением',
			default => '❌ Ошибка валидации',
		};
	}
}

abstract class Model
{
	private readonly array $_attributesRules;
	public static array $VALIDATORS = [];

	public function __construct()
	{
		$this->_attributesRules = $this->getRules();
		self::$VALIDATORS[ModelRule::IMPORTANT->value] = fn($attribute, null $rule_value): bool => isset($this->{$attribute});
		self::$VALIDATORS[ModelRule::TEXT_MAX->value] = fn($attribute, int $max): bool => strlen($this->{$attribute}) <= $max;
		self::$VALIDATORS[ModelRule::TEXT_MIN->value] = fn($attribute, int $min): bool => strlen($this->{$attribute}) >= $min;
		self::$VALIDATORS[ModelRule::NUMBER_MAX->value] = fn($attribute, int $max): bool => $this->{$attribute} <= $max;
		self::$VALIDATORS[ModelRule::NUMBER_MIN->value] = fn($attribute, int $min): bool => $this->{$attribute} >= $min;
		self::$VALIDATORS[ModelRule::EMAIL->value] = fn($attribute, null $rule_value): bool => filter_var($this->{$attribute}, FILTER_VALIDATE_EMAIL);
		self::$VALIDATORS[ModelRule::MATCH ->value] = fn($attribute, string $rule_value): bool => $this->{$rule_value} === $this->{$attribute};
		self::$VALIDATORS[ModelRule::NUMBER->value] = fn($attribute, null $rule_value): bool => is_numeric($this->{$attribute});
		self::$VALIDATORS[ModelRule::IMG->value] = fn($attribute, null $rule_value): bool => $this->isImageBase64($this->{$attribute});
	}

	public function loadData($data)
	{
		foreach ($data as $key => $value) {
			if (property_exists($this, $key)) {
				$this->{$key} = $value;
			}
		}
	}

	private function getModelDatabaseAttributes(): array
	{
		$ref = new ReflectionClass($this);
		return $ref->getAttributes(ModelDatabaseAttribute::class);
	}

	private function getProps(): array
	{
		$ref = new ReflectionClass($this);
		return $ref->getProperties(ReflectionProperty::IS_PUBLIC);
	}

	public function getTableName(): string
	{
		return $this->getModelDatabaseAttributes()[0]->newInstance()->table_name;
	}

	public function getDatabaseProps(): array|null
	{
		$attrs = $this->getModelDatabaseAttributes();
		if (empty($attrs)) {
			return null;
		}
		return $attrs[0]->newInstance()->table_collumn_names ?? null;
	}

	public function getRules(): array
	{
		$result = [];
		foreach ($this->getProps() as $prop) {
			$name = $prop->getName();
			$result[$name] = [];
			$attrs = $prop->getAttributes(ModelPropRuleAttribute::class);
			if (empty($attrs)) {
				continue;
			}

			foreach ($attrs as $attr) {
				$el = $attr->newInstance();
				$result[$name][$el->rule->value] = $el->value;
			}
		}
		return $result;
	}

	public function validate()
	{
		foreach ($this->_attributesRules as $attribute => $rules) {
			foreach ($rules as $rule => $rule_value) {
				if (!isset($this->{$attribute})) {
					if (isset($rules[ModelRule::IMPORTANT->value])) {
						Application::$app->error->pushClientError($attribute, ModelRule::from(ModelRule::IMPORTANT->value)->message(null));
					}
					break;
				}
				if (!self::$VALIDATORS[$rule]($attribute, $rule_value)) {
					Application::$app->error->pushClientError($attribute, ModelRule::from($rule)->message($rule_value));
				}
			}
		}
		return Application::$app->error->clientErrorsIsEmpty() == true;
	}


	private static function isImageBase64($base64String): bool
	{

		echo var_dump($base64String);
		if (preg_match('/^data:image\/(png|jpeg|jpg|gif);base64,/', $base64String, $matches)) {
			$data = substr($base64String, strlen($matches[0]));
			if (base64_decode($data, true) !== false) {
				$image = \imagecreatefromstring(base64_decode($data));
				if ($image !== false) {
					return true;
				}
			}
		}
		return false;
	}

}
