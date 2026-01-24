<?php

namespace ProductHack\controllers;

use ProductHack\core\Application;
use ProductHack\core\Controller;
use ProductHack\core\Request;
use ProductHack\core\Session;
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
			Application::$app->error->pushClientError("any", "User already created or bad registartion");
			return;
		}
		return $this->redirect("/authorization");
	}

	public function logout(Request $request)
	{
		$this->layout = "empty_workflow";
		if (!new SessionModel()->deleteFromProp("token", Session::token())) {
			return $this->redirect("/authorization");
		}
		return $this->redirect("/index");
	}

	public function login(Request $request)
	{
		$model = new LoginModel();
		$model->loadData($request->getData());
		if (!$model->validate()) {
			return $this->renderPage("authorization", ["page_title" => "🍇 Авторизация пользователя"]);
		}
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
}
