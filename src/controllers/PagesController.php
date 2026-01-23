<?php

namespace ProductHack\controllers;

use ProductHack\core\Controller;
use ProductHack\core\Request;
use ProductHack\models\LoginModel;
use ProductHack\models\ProductModel;
use ProductHack\models\SessionModel;

class PagesController extends Controller
{
	public static PagesController $instance;

	public function __construct()
	{
		if (empty(self::$instance)) {
			self::$instance = $this;
		}
	}

	public function test(Request $request): string
	{
		$this->layout = "empty_workflow";
		$model = new LoginModel();
		return $this->renderDump([]);
	}

	public function catalog(Request $request)
	{
		$productModel = new ProductModel();
		return $this->render('catalog', [
			"page_title" => "🍇 Винный каталог",
			"model" => $productModel->selectAll(),
		]);
	}
	public function payment(Request $request)
	{
		return $this->render('payment', [
			"page_title" => "🍇 Страница оплаты"
		]);
	}
	public function profile(Request $request)
	{
		$session = new SessionModel();
		if ($session->loadFromPHPSESSID()) {
			$user = $session->getUser();
			if ($user->role_id != 0)
				return $this->render('profile', ["page_title" => "🍇 Страница пользователя"]);
		}
		return $this->redirect("/authorization");
	}

	public function contacts(Request $request)
	{
		return $this->render('contacts', [
			"page_title" => "🍇 Страница пользователя"
		]);
	}


	public function admin(Request $request)
	{
		$session = new SessionModel();
		if ($session->loadFromPHPSESSID()) {
			$user = $session->getUser();
			if ($user->role_id == 2)
				return $this->render('admin', ["page_title" => "🍇 Админ"]);
		}
		return $this->redirect("/authorization");
	}

	public function main(Request $request)
	{
		return $this->render('main', [
			"page_title" => "🍇 Винный магазин",
		]);
	}

	public function aboutus(Request $request)
	{
		return $this->render('aboutus', [
			"page_title" => "🍇 О нас",
		]);
	}

	public function authorization(Request $request)
	{
		$session = new SessionModel();
		if ($session->loadFromPHPSESSID()) {
			$user = $session->getUser();
			if ($user->role_id > 0)
				return $this->redirect("/profile");
		}
		return $this->render('authorization', [
			"page_title" => "🍇 Авторизация пользователя",
		]);
	}
}
