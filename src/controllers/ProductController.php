<?php

namespace ProductHack\controllers;

use ProductHack\core\Application;
use ProductHack\core\Controller;
use ProductHack\core\Request;
use ProductHack\models\ImagesModel;
use ProductHack\models\ProductModel;

class ProductController extends Controller
{
	public function create(Request $request)
	{
		$model = new ProductModel();
		$model->loadData($request->getData());
		if ($model->validate()) {
			if (!$model->create()) {
				Application::$app->error->pushClientError("any", "Product bad created");
			}
		}
		return $this->renderPage("admin");
	}

	public function delete(Request $request)
	{
		$model = new ProductModel();
		$model->loadData($request->getData());
		$model->loadFromWhere("id", $model->id);
		if ($model->validate()) {
			$imagesModel = new ImagesModel();
			$imageDeleted = true;
			foreach (explode(',', $model->ids_images) as $value) {
				if (!$imagesModel->deleteFromProp("id", $value)) {
					Application::$app->error->pushClientError($value . "image", "Image with id(" . $value . ") bad deleted");
					$imageDeleted = false;
				}
			}
			if (!$imageDeleted || !$model->delete($model->id)) {
				Application::$app->error->pushClientError("any", "Product bad delted");
			}
		}
		return $this->renderPage("admin");
	}

	public function change(Request $request)
	{
		return $this->redirect("admin");
	}
}
