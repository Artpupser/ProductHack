<?php

namespace ProductHack\controllers;

use ProductHack\core\Application;
use ProductHack\core\Controller;
use ProductHack\core\Request;
use ProductHack\models\ProductModel;

class ProductController extends Controller
{

    public function create(Request $request) {
        if(!$request->isPost()) return $this->renderBadJson();
        $this->layout="empty_workflow";
        $model = new ProductModel();
        $model->loadData($request->getContent());
        $model->image = file_get_contents($_FILES["image"]["tmp_name"]);
        if($model->validate() && $model->create()) {
            return 'Success';
        }
        return $this->render('admin', [
            'model' => $model,
        ]);
    }

    public function delete(Request $request) {
        if(!$request->isPost()) return $this->renderBadJson();
        $this->layout="empty_workflow";

        return $this->renderJson($request);}
  
    public function change(Request $request) {
        if(!$request->isPost()) return $this->renderBadJson();
        $this->layout="empty_workflow";

        return $this->renderJson($request);}
}