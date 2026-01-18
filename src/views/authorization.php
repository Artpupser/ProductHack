<div class="container_con">
	<section class="section_con">
		<div id="login-form" style="display: block;">
			<h2>Авторизация</h2>
			<form class="contact-form" method="POST" action="/api/user/login">
				<label for="login_email">Почта</label>
				<input type="tel" id="phone" name="phone" placeholder="Введите почту" required />

				<label for="login_password">Пароль</label>
				<input type="text" id="password" name="password" placeholder="Введите пароль" required />

				<button type="submit"> Вход</button>
				<p>Еще не зарегистрировались?</p>
				<button type="button" onclick="showRegisterForm()">Зарегистрироваться!</button>
			</form>
		</div>

		<div id="register-form" style="display: none;">
			<h2>Регистрация</h2>
			<form class="contact-form" method="POST" action="/api/user/registration">
				<label for="registration_email">Почта</label>
				<input type="email" id="email" name="email" placeholder="Введите почту" required />

				<label for="registration_password">Пароль</label>
				<input type="password" id="password" name="password" placeholder="Введите Пароль" required />

				<label for="registration_repeat_password">Повтор пароля</label>
				<input type="password" id="repeat_password" name="repeat_password" placeholder="Повтор пароля" required />

				<button type="submit">Зарегистрироваться</button>
				<p>Уже есть аккаунт?</p>
				<button type="button" onclick="showLoginForm()">Войти!</button>
			</form>
		</div>
	</section>
</div>