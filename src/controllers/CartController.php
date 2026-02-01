<?php

namespace ProductHack\controllers;

use ProductHack\core\Controller;
use ProductHack\core\Request;
use ProductHack\models\CartModel;
use ProductHack\models\ProductModel;

class CartController extends Controller
{
	private function actionIfValid(Request $request, callable $action)
	{
		$cartModel = new CartModel();
		$cartModel->loadData($request->getData());
		if ($cartModel->validate()) {
			return $action($cartModel);
		}
		return $this->renderJson(["status" => "error"]);
	}
	public function change(Request $request)
	{
		$this->actionIfValid($request, function (CartModel $cartModel) use ($request) {
			if (!isset($_SESSION['cart'])) {
				$_SESSION['cart'] = [];
			}
			$productModel = new ProductModel();
			if ($productModel->loadFromWhere("id", $cartModel->id)) {
				$_SESSION['cart'][$cartModel->id] = $cartModel->cost ?? 1;
				$this->renderJson(["status" => "ok", "result" => $_SESSION['cart'][$cartModel->id]]);
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
		$this->actionIfValid($request, function (CartModel $cartModel) {
			unset($_SESSION['cart'][$cartModel->id]);
			$this->renderJson(["status" => "ok"]);
		});
	}
	public function clear(Request $request)
	{
		$this->actionIfValid($request, function (CartModel $cartModel) {
			unset($_SESSION['cart']);
			$this->renderJson(["status" => "ok"]);
		});
	}
}
