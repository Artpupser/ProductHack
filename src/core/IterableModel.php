<?php

namespace ProductHack\core;
/**
 * @template T of ModelDatabase
 */
abstract class IterableModel extends ModelDatabase
{
	/**
	 * @var array<T>
	 */
	public array $pool = [];

	public function loadAll(): void
	{
		$result = $this->selectAll();
		foreach ($result as $value) {
			/**
			 * @var T
			 */
			$model = $this->createModel();
			$model->loadData($value);
			$this->pool[] = $model;
		}
	}
	public function loadFrom(string $attribute, $value): void
	{
		$result = $this->selectWhereEqual($attribute, $value);
		foreach ($result as $value) {
			/**
			 * @var T
			 */
			$model = $this->createModel();
			$model->loadData($value);
			$this->pool[] = $model;
		}
	}
	/**
	 * @return T
	 */
	public function getFirst(): ModelDatabase
	{
		return $this->pool[0];
	}
	/**
	 * @return T
	 */
	protected abstract function createModel(): ModelDatabase;
}