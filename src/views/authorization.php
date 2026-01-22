<div class="container_con">
	<section class="section_con">
		<div id="login-form">
			<h2>Авторизация</h2>
			<form class="contact-form" method="POST" action="/api/user/login">
				<label for="login_email">Почта</label>
				<input type="email" id="login_email" name="email" placeholder="Введите почту" required>

				<label for="login_password">Пароль</label>
				<input type="password" id="login_password" name="password" placeholder="Введите пароль" required>

				<button type="submit"> Вход</button>
				<p class="switch-p">Еще не зарегистрировались?</p>
				<button type="button" class="switch-btn" onclick="showRegisterForm()">Зарегистрироваться!</button>
			</form>
		</div>

		<div id="register-form" style="display:none">
			<h2>Регистрация</h2>
			<form class="contact-form" method="POST" action="/api/user/registration">
				<label for="registration_email">Почта</label>
				<input type="email" id="reg_email" name="email" placeholder="Введите почту" required />

				<label for="registration_password">Пароль</label>
				<input type="password" id="reg_password" name="password" placeholder="Введите Пароль" required />

				<label for="registration_repeat_password">Повтор пароля</label>
				<input type="password" id="reg_password" name="repeat_password" placeholder="Повтор пароля" required />

				<button type="submit">Зарегистрироваться</button>
				<p class="switch-p">Уже есть аккаунт?</p>
				<button type="button" class="switch-btn" onclick="showLoginForm()">Войти!</button>
			</form>
		</div>
	</section>
</div>