<div class="container_con">
	<section class="section_con">
		<div id="login-form">
			<h2>Авторизация</h2>
			<?php
			use ProductHack\components\Form;
			$loginForm = Form::begin("/api/user/login") ?>
			<?php $loginForm->field("email", "Почта", "text"); ?>
			<?php $loginForm->field("password", "Пароль", "password"); ?>
			<?php Form::end("Вход") ?>
			<p class="switch-p">Еще не зарегистрировались?</p>
			<button type="button" class="auth-btn" onclick="showRegisterForm()">Зарегистрироваться!</button>
		</div>

		<div id="register-form" style="display:none">
			<h2>Регистрация</h2>
			<?php $registrationForm = Form::begin("/api/user/registration") ?>
			<?php $registrationForm->field("email", "Почта", "text"); ?>
			<?php $registrationForm->field("password", "Пароль", "password"); ?>
			<?php $registrationForm->field("repeat_password", "Повтор пароля", "password"); ?>
			<?php Form::end("Зарегистрироваться") ?>
			<p class="switch-p">Уже есть аккаунт?</p>
			<button type="button" class="auth-btn" onclick="showLoginForm()">Войти!</button>
		</div>
	</section>
</div>