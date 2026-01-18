<?php

namespace ProductHack\controllers;

use ProductHack\core\Application;
use ProductHack\core\Controller;
use ProductHack\core\Request;
use ProductHack\models\EmailVerificationModel;
use ProductHack\models\RegistrationModel;

class AuthorizationController extends Controller
{

	public function registration(Request $request)
	{
		$this->layout = "empty_workflow";
		$model = new RegistrationModel();
		$model->loadData($request->getData());
		if ($model->validate() === false) {
			return Application::$app->router->renderContent(var_dump($model->errors));
		}
		if($model->existsInDb("email", $model->email)) {
			$model->addError("any", "User already created");
			return Application::$app->router->renderContent(var_dump($model->errors));
		}
		if ($model->create() === false) {
			return PagesController::renderCustomError($request, 400);
		}
		return $this->redirect("/index");
	}

	public function send_code(Request $request)
	{
		$this->layout = "empty_workflow";
		$model = new EmailVerificationModel();
		$model->loadData($request->getData());
		return Application::$app->router->renderContent($request->getDataJson());
	}

	public function login(Request $request)
	{
		$this->layout = "empty_workflow";
		return Application::$app->router->renderContent($request->getDataJson());
	}

	public function logout(Request $request)
	{
		$this->layout = "empty_workflow";
		return Application::$app->router->renderContent($request->getDataJson());
	}
}
