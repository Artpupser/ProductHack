<?php

namespace ProductHack\controllers;

use ProductHack\core\Application;
use ProductHack\core\Controller;
use ProductHack\core\Request;
use ProductHack\models\CartItemModel;
use ProductHack\models\ProductModel;

class CartController extends Controller
{
	private function actionIfValid(Request $request, callable $action)
	{
		$cartItemModel = new CartItemModel();
		$cartItemModel->loadData($request->getData());
		if ($cartItemModel->validate()) {
			return $action($cartItemModel);
		}
		Application::$app->error->pushServerError(400, "Input data not correct or bad request");
		return $this->renderJson([]);
	}
	public function change(Request $request)
	{
		$this->actionIfValid($request, function (CartItemModel $cartItemModel) use ($request) {
			if (!isset($_SESSION['cart'])) {
				$_SESSION['cart'] = [];
			}
			$productModel = new ProductModel();
			if ($productModel->loadFromWhere("id", $cartItemModel->id)) {
				$_SESSION['cart'][$cartItemModel->id] = $cartItemModel;
				$this->renderJson(["status" => "ok", "result" => $_SESSION['cart'][$cartItemModel->id]]);
				return;
			}
			$this->renderJson(["status" => "error", "result" => "product undefiend"]);
		});
	}
	public function get(Request $request)
	{
		if (!isset($_SESSION['cart'])) {
			$_SESSION['cart'] = [];
		}
		foreach ($_SESSION['cart'] as $id => $cost) {
			$productModel = new ProductModel();
			if (!$productModel->loadFromWhere("id", $id)) {
				$_SESSION['cart'][$id];
			}
		}
		$this->renderJson(["status" => "ok", "result" => $_SESSION['cart']]);
	}
	public function delete(Request $request)
	{
		$this->actionIfValid($request, function (CartItemModel $cartItemModel) {
			unset($_SESSION['cart'][$cartItemModel->id]);
			$this->renderJson(["status" => "ok"]);
		});
	}
	public function clear(Request $request)
	{
		$this->actionIfValid($request, function (CartItemModel $cartItemModel) {
			unset($_SESSION['cart']);
			$this->renderJson(["status" => "ok"]);
		});
	}
}
