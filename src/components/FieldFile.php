<?php
namespace ProductHack\components;

class FieldFile extends Field
{
	protected string $_accept;
	public function __construct(string $id, string $label = 'None', string $accept = '*')
	{
		$this->_id = $id;
		$this->_type = "file";
		$this->_label = $label;
		$this->_accept = $accept;
	}

	public function __toString(): string
	{
		return "<label for='$this->_id'>$this->_label</label>
			<input accept='$this->_accept' type='$this->_type' name='$this->_id' placeholder='Пусто' required>";
	}
}