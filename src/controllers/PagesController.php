<?php

namespace ProductHack\controllers;

use ProductHack\core\Controller;
use ProductHack\core\Request;
use ProductHack\core\Session;

class PagesController extends Controller
{
	public function profile(Request $request)
	{
		if (Session::$CURRENT_USER?->isUser())
			return $this->renderPage('profile');
		return $this->redirect("authorization");
	}

	public function admin(Request $request)
	{
		if (Session::$CURRENT_USER?->isAdmin())
			return $this->renderPage('admin');
		return $this->redirect("authorization");
	}

	public function cart(Request $request)
	{
		if (Session::$CURRENT_USER?->isUser())
			return $this->renderPage('cart');
		return $this->redirect("authorization");
	}

	public function authorization(Request $request)
	{
		if (Session::$CURRENT_USER?->isUser())
			return $this->redirect("profile");
		return $this->renderPage('authorization');
	}

	public function contacts(Request $request)
	{
		return $this->renderPage('contacts');
	}

	public function main(Request $request)
	{
		return $this->renderPage('main');
	}

	public function aboutus(Request $request)
	{
		return $this->renderPage('aboutus');
	}

	public function catalog(Request $request)
	{
		return $this->renderPage('catalog');
	}

	public function payment(Request $request)
	{
		if (Session::$CURRENT_USER?->isUser())
			return $this->renderPage('payment');
		return $this->redirect("authorization");
	}
}
