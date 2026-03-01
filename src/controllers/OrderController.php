<?php

namespace ProductHack\controllers;

use ProductHack\core\Application;
use ProductHack\core\Controller;
use ProductHack\core\Request;
use ProductHack\models\OrderModel;

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

	public function get_price(Request $request)
	{
		$order = new OrderModel();
		$order->loadFromWhere("id", $request->getData()["id"]);
		if ($order->validate()) {
			$this->renderJson(['value' => $order->total_price]);
		}
		Application::$app->error->pushServerError(400, "Order not found");
		return $this->renderJson([]);
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
