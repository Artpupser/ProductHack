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
		$model = new RegistrationModel();
		$model->loadData($request->getData());
		if ($model->validate()) {
			if (!$model->registration()) {
				Application::$app->error->pushClientError("any", "User already created or bad registartion");
			}
		}
		return $this->renderPage("authorization");
	}

	public function login(Request $request)
	{
		$model = new LoginModel();
		$model->loadData($request->getData());
		if ($model->validate()) {
			if ($model->enter()) {
				$sessionModel = new SessionModel();
				$sessionModel->create($model);
				return $this->redirect("profile");
			}
			Application::$app->error->pushClientError("any", "Client not found");
		}
		return $this->renderPage("authorization");
	}

	public function logout(Request $request)
	{
		if (!new SessionModel()->deleteFromProp("token", Session::token())) {
			return $this->redirect("authorization");
		}
		return $this->redirect("index");
	}

	public function sendCode(Request $request)
	{
		$model = new EmailVerificationModel();
		$model->loadData($request->getData());
		return Application::$app->router->renderContent($request->getDataJson());
	}
}
