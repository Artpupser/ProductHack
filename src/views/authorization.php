<body class="body_log">
    <div class="auth-container">
        <div class="form-container login-form active">
            <div class="form-header">
                <h1 class="bergamasco-regular">ВХОД</h1>
                <a href="#" class="switch-link bergamasco-regular" data-target="register">регистрация</a>
            </div>
            <form id="loginForm" action='/login' method='POST'>
                <input type="hidden" name="action" value="login">
                <div class="input-group">
                    <input type="text" id="loginUsername" name="username" required class="bergamasco-regular">
                    <label for="loginUsername" class="bergamasco-regular">Имя</label>
                </div>
                <div class="input-group">
                    <input type="password" id="loginPassword" name="password" required class="bergamasco-regular">
                    <label for="loginPassword" class="bergamasco-regular">Пароль</label>
                    <span class="toggle-password" data-target="loginPassword">👁️</span>
                </div>
                <button type="submit" class="submit-btn bergamasco-regular">ВОЙТИ</button>
                <a href="#" class="forgot-password bergamasco-regular">забыли пароль?</a>
            </form>
        </div>

        <!-- Форма регистрации -->
        <div class="form-container register-form">
            <div class="form-header">
                <h1 class="bergamasco-regular">РЕГИСТРАЦИЯ</h1>
                <a href="#" class="switch-link bergamasco-regular" data-target="login">вход</a>
            </div>
            <form id="registerForm" action='/registration' method='POST'>
                <input type="hidden" name="action" value="register">
                <div class="input-group">
                    <input type="text" id="registerUsername" name="username" required class="bergamasco-regular">
                    <label for="registerUsername" class="bergamasco-regular">Имя</label>
                </div>
                <div class="input-group">
                    <input type="email" id="registerEmail" name="email" required class="bergamasco-regular">
                    <label for="registerEmail" class="bergamasco-regular">Email</label>
                </div>
                <div class="input-group">
                    <input type="password" id="registerPassword" name="password" required class="bergamasco-regular">
                    <label for="registerPassword" class="bergamasco-regular">Пароль</label>
                    <span class="toggle-password" data-target="registerPassword">👁️</span>
                </div>
                <div class="input-group">
                    <input type="password" id="confirmPassword" name="confirm_password" required class="bergamasco-regular">
                    <label for="confirmPassword" class="bergamasco-regular">Повторите пароль</label>
                    <span class="toggle-password" data-target="confirmPassword">👁️</span>
                </div>
                <button type="submit" class="submit-btn bergamasco-regular">ЗАРЕГИСТРИРОВАТЬСЯ</button>
            </form>
        </div>
    </div>
</body>
<script src="./public/js/log.js"></script>