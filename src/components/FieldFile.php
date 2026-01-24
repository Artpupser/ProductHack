<?php
namespace ProductHack\components;

class FieldFile extends Field
{
	public function __construct(string $id, string $label = 'None', string $type = 'text')
	{
		$this->_id = $id;
		$this->_type = $type;
		$this->_label = $label;
	}

	public function __toString(): string
	{
		return "<label for='$this->_id'>$this->_label</label>
			<input accept='image/*' type='$this->_type' name='$this->_id' placeholder='Пусто' required>";
	}
}