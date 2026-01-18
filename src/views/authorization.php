<div class="container_con">
	<section class="section_con">
		<div id="login-form" style="display: block;">
			<h2>Авторизация</h2>
			<form class="contact-form" method="POST" action="/api/user/send_code">
				<div>
					<div>
						<label for="login_phone">Телефон</label>
						<input type="tel" id="login_phone" name="phone" placeholder="Введите ваш номер телефона" required />
					</div>
					<button type="button">
						Отправить код
					</button>
				</div>
			</form>
			<form class="contact-form" method="POST" action="/api/user/login">
				<label for="login_code">Код подтверждения</label>
				<input type="text" id="login_code" name="code" placeholder="Введите код" required />

				<button type="submit">Войти</button>
				<button type="button" onclick="showRegisterForm()">Регистрация</button>
			</form>
		</div>

		<div id="register-form" style="display: none;">
			<h2>Регистрация</h2>
			<form class="contact-form" method="POST" action="/api/user/registration">
				<label for="register_name">Имя</label>
				<input type="text" id="register_name" name="name" placeholder="Введите своё имя" required />

				<div>
					<div>
						<label for="login_phone">Телефон</label>
						<input type="tel" id="login_phone" name="phone" placeholder="Введите ваш номер телефона" required />
					</div>
					<button type="button">
						Отправить код
					</button>
				</div>

				<label for="register_code">Код подтверждения</label>
				<input type="text" id="register_code" name="code" placeholder="Введите код" required />

				<button type="submit">Зарегистрироваться</button>
				<button type="button" onclick="showLoginForm()">Авторизация</button>
			</form>
		</div>
	</section>
</div>