<?php

namespace ProductHack\controllers;

use ProductHack\core\Application;
use ProductHack\core\Controller;
use ProductHack\core\Request;
use ProductHack\models\EmailVerificationModel;
use ProductHack\models\LoginModel;
use ProductHack\models\RegistrationModel;
use ProductHack\models\SessionModel;

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
		if ($model->existsInDb("email", $model->email)) {
			$model->addError("any", "User already created");
			return Application::$app->router->renderContent(var_dump($model->errors));
		}
		if ($model->create() === false) {
			return Application::$app->error->pushClientError("any", "Model not created");
		}
		return $this->redirect("/index");
	}

	public function login(Request $request)
	{
		$this->layout = "empty_workflow";
		$model = new LoginModel();
		$model->loadData($request->getData());
		if ($model->validate() === false) {
			return "";
		}
		if ($model->check() === false) {
			return Application::$app->error->pushServerError(400);
		}
		$sessionModel = new SessionModel();
		$sessionModel->create($model->email);
		return $this->redirect("/index");
	}

	public function send_code(Request $request)
	{
		$this->layout = "empty_workflow";
		$model = new EmailVerificationModel();
		$model->loadData($request->getData());
		return Application::$app->router->renderContent($request->getDataJson());
	}

	public function logout(Request $request)
	{
		$this->layout = "empty_workflow";
		return Application::$app->router->renderContent($request->getDataJson());
	}
}
