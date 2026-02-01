<?php
namespace ProductHack\components;

class FieldMessage extends Field
{
	public function __construct(string $id, string $label = 'None')
	{
		$this->_id = $id;
		$this->_type = "text";
		$this->_label = $label;
	}

	public function __toString(): string
	{
		return "<label for='$this->_id'>$this->_label</label>
			<textarea type='$this->_type' name='$this->_id' rows='5' placeholder='Пусто' required></textarea>";
	}
}