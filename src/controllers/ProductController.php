<?php

namespace ProductHack\controllers;

use ProductHack\core\Application;
use ProductHack\core\Controller;
use ProductHack\core\Request;
use ProductHack\models\ImagesModel;
use ProductHack\models\ProductModel;

class ProductController extends Controller
{
    public function __construct()
    {
        $this->layout="empty_workflow";
    }
    public function create(Request $request) {
        if(!$request->isPost()) 
            return PagesController::$instance->renderCustomError($request, 403);
        $model = new ProductModel();
        $model->loadData($request->getContent());
        if($model->validate() && $model->create()) {
            return $this->redirect("/admin");
        }
        return PagesController::$instance->renderCustomError($request, 403);

    }

    public function delete(Request $request) {
        if(!$request->isPost()) 
            return PagesController::$instance->renderCustomError($request, 403);
        $model = new ProductModel();
        $model->loadData($request->getContent());
        $imagesModel = new ImagesModel();
        $model->ids_images = $model->selectWhereEqual("id", $model->id)[0]["ids_images"];
        foreach (explode(',', $model->ids_images) as $value) {
            if (!$imagesModel->deleteFromId($value)) {
                return PagesController::$instance->renderCustomError($request, 403);
            };
        }
        if($model->validate() && $model->delete($model->id)) {
            return $this->redirect("/admin");
        }
        return PagesController::$instance->renderCustomError($request, 403);
    }
  
    public function change(Request $request) {
        if(!$request->isPost())
            return PagesController::$instance->renderCustomError($request, 403);
        return $this->redirect("/admin");
    }
}