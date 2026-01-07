<div class="container_con">
    <section class="section_con">
        <!-- Форма авторизации -->
        <div id="login-form" style="display: block;">
            <h2>Авторизация</h2>
            <form class="contact-form" method="POST" action="">
                <label for="login_email">Email</label>
                <input type="email" id="login_email" name="email" placeholder="Ваш email" required />

                <label for="login_password">Пароль</label>
                <input type="password" id="login_password" name="password" placeholder="Ваш пароль" required />
                
                <button type="submit">Войти</button>
                <button type="button" onclick="showRegisterForm()">Регистрация</button>
            </form>
        </div>

        <!-- Форма регистрации -->
        <div id="register-form" style="display: none;">
            <h2>Регистрация</h2>
            <form class="contact-form" method="POST" action="">
                <label for="register_name">Имя</label>
                <input type="text" id="register_name" name="name" placeholder="Введите своё имя" required />

                <label for="register_email">Email</label>
                <input type="email" id="register_email" name="email" placeholder="Введите ваш email" required />

                <label for="register_age">Год рождения</label>
                <input type="number" id="register_age" name="age" placeholder="Введите свой год рождения" required />

                <label for="register_password">Пароль</label>
                <input type="password" id="register_password" name="password" placeholder="Введите пароль" required />

                <label for="repeat_password">Повторить пароль</label>
                <input type="password" id="repeat_password" name="repeat_password" placeholder="Повторите пароль" required />

                <button type="submit">Зарегистрироваться</button>
                <button type="button" onclick="showLoginForm()">Авторизация</button>
            </form>
        </div>
    </section>
</div>
