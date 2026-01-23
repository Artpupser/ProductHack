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
		if (!$model->validate()) {
			return;
		}
		if (!$model->registration()) {
			return Application::$app->error->pushClientError("any", "User already created or bad registartion");
		}
		return $this->redirect("/authorization");
	}

	public function login(Request $request)
	{
		$this->layout = "empty_workflow";
		$model = new LoginModel();
		$model->loadData($request->getData());
		if (!$model->validate())
			return;
		if (!$model->enter()) {
			Application::$app->error->pushClientError("any", "Client not found");
			return Application::$app->router->renderContent(var_dump(Application::$app->error->getClientErrors()));
		}
		$sessionModel = new SessionModel();
		$sessionModel->create($model);
		return $this->redirect("/profile");
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
