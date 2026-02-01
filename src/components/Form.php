<?php
namespace ProductHack\components;

class Form
{
	public static function begin(string $action): Form
	{
		echo "<form class='contact-form' method='POST' action='$action'>";
		return new Form();
	}
	public static function beginWithFile(string $action): Form
	{
		echo "<form class='contact-form' method='POST' action='$action' enctype='multipart/form-data'>";
		return new Form();
	}
	public function field(string $id, string $label, string $type)
	{
		echo new Field($id, $label, $type);
	}
	public function fieldMessage(string $id, string $label, string $type)
	{
		echo new FieldMessage($id, $label);
	}
	public function fieldFile(string $id, string $label, string $accpet)
	{
		echo new FieldFile($id, $label, $accpet);
	}
	public static function end(string $submitLabel = 'Отправить')
	{
		echo "<button type='submit'>$submitLabel</button></form>";
	}
}