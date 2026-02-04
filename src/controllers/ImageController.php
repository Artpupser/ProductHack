<?php

namespace ProductHack\controllers;

use ProductHack\core\Application;
use ProductHack\core\Controller;
use ProductHack\core\Request;
use ProductHack\models\ImageModel;

class ImageController extends Controller
{
	public function create(Request $request)
	{
		$model = new ImageModel();
		$rData = $request->getData();
		$model->loadData($rData);
		$model->base64 = $rData["images"]["base64"];
		if ($model->validate()) {
			if (!$model->create()) {
				Application::$app->error->pushClientError("any", "Image bad created");
			}
		}
		return $this->renderPage("admin");
	}

	public function delete(Request $request)
	{
		$model = new ImageModel();
		$model->loadData($request->getData());
		if ($model->validate()) {
			if (!$model->delete()) {
				Application::$app->error->pushClientError("any", "Image bad deleted");
			}
		}
		return $this->renderPage("admin");
	}

}
