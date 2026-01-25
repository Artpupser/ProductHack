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
		return $this->renderPage('catalog', [
			"model" => $productModel->selectAll(),
		]);
	}
	public function payment(Request $request)
	{
		return $this->renderPage('payment');
	}
	public function profile(Request $request)
	{
		$session = new SessionModel();
		if ($session->loadFromPHPSESSID()) {
			$user = $session->getUser();
			if ($user->role_id != 0)
				return $this->renderPage('profile');
		}
		return $this->redirect("authorization");
	}

	public function contacts(Request $request)
	{
		return $this->renderPage('contacts');
	}

	public function admin(Request $request)
	{
		$session = new SessionModel();
		if ($session->loadFromPHPSESSID()) {
			$user = $session->getUser();
			if ($user->role_id == 2)
				return $this->renderPage('admin');
		}
		return $this->redirect("authorization");
	}

	public function main(Request $request)
	{
		return $this->renderPage('main');
	}

	public function cart(Request $request)
	{
		return $this->renderPage('cart');
	}

	public function aboutus(Request $request)
	{
		return $this->renderPage('aboutus');
	}

	public function authorization(Request $request)
	{
		$session = new SessionModel();
		if ($session->loadFromPHPSESSID()) {
			$user = $session->getUser();
			if ($user->role_id > 0)
				return $this->redirect("profile");
		}
		return $this->renderPage('authorization');
	}
}
