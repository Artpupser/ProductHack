<?php

namespace ProductHack\core;

use ProductHack\models\SessionModel;

class Session
{
	public function __construct() {}

	public static function get_session_data(): array
	{
		return $_SESSION;
	}

	public static function start_session()
	{
		session_start();
	}

	public function create_new_session() {}

	public function load_session()
	{
		if (isset($_COOKIE["PHPSESSID"])) {
			$model = new SessionModel();
		}
	}
}
