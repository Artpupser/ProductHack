<?php
namespace ProductHack\components;

use ProductHack\core\ClientErrors;

class Form
{
	public static function begin(string $action): Form
	{
		echo "<form class='contact-form' method='POST' action='$action'>";
		return new Form();
	}
	public function field(string $id, string $label, string $type)
	{
		echo new Field($id, $label, $type);
	}
	public static function end(string $submitLabel = 'Отправить')
	{
		echo "<button type='submit'>$submitLabel</button></form>";
	}
}