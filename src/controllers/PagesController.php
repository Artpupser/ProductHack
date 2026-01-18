<?php

namespace ProductHack\controllers;

use ProductHack\core\Controller;
use ProductHack\core\Request;
use ProductHack\core\Application;
use ProductHack\core\Session;
use ProductHack\models\ProductModel;

class PagesController extends Controller
{
	public static PagesController $instance;

	public function __construct()
	{
		if (empty(self::$instance)) {
			self::$instance = $this;
		}
	}

	public static function renderCustomError(Request $request, int $code = 403)
	{
		Application::$app->response->setStatusCode($code);
		return PagesController::$instance->error($request);
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
		// $user = Session::get_user();
		// if (is_null($user) || $user->role_id != 1) {
		// 	$this->redirect("/authorization");
		// 	return null;
		// }
		return $this->render('profile', [
			"page_title" => "🍇 Страница пользователя"
		]);
	}

	public function card_product(Request $request)
	{
		return $this->render('card_product', [
			"page_title" => "🍇 Card product"
		]);
	}

	public function contacts(Request $request)
	{
		return $this->render('contacts', [
			"page_title" => "🍇 Страница пользователя"
		]);
	}


	public function admin(Request $request)
	{
		return $this->render('admin', [
			"page_title" => "🍇 Админ"
		]);
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
		$user = Session::get_user();
		echo var_dump($user);
		if (!is_null($user) && $user->role_id == 1) {
			$this->redirect("/profile");
			return null;
		}
		return $this->render('authorization', [
			"page_title" => "🍇 Авторизация пользователя",
		]);
	}

	public function error(Request $request)
	{
		$code = Application::$app->response->getStatusCode();
		return $this->render('error', [
			"page_title" => "🍇 Ошибка, " . $code,
			"code" => $code,
			"message" => Application::$app->errorMessage($code),
		]);
	}
}
