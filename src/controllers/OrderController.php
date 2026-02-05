<?php

namespace ProductHack\controllers;

use ProductHack\core\Application;
use ProductHack\core\Controller;
use ProductHack\core\Request;
use ProductHack\core\Session;
use ProductHack\models\CartModel;
use ProductHack\models\OrderItemModel;
use ProductHack\models\OrderModel;
use ProductHack\models\OrderStatus;
use ProductHack\models\ProductModel;

class OrderController extends Controller
{
	public function create(Request $request)
	{
		$order = new OrderModel();
		$order->initOrder();
		if ($order->validate()) {
			if (!$order->create()) {
				Application::$app->error->pushClientError("any", "Order bad created");
			}
		}
		return $this->redirect("profile");
	}

	public function change_status(Request $request)
	{
		$order = new OrderModel();
		$order->loadData($request->getData());
		if (!$order->changeColumn("status_id", $order->status_id, $order->id)) {
			Application::$app->error->pushClientError("any", "Order bad status changewd");
		}
		return $this->redirect("profile");
	}
}
