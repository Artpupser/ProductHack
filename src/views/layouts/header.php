<header class="header_main">
    <div class="logo">
        <img src="./assets/logo.png" alt="Логотип">
    </div>
    <p class="wineshop">Винный магазин</p>
    <div class="place flex-center flex-row">
        <div class="img-place">
            <img src="./assets/place.png" alt="Местоположение">
        </div>
        <div class="flex-column">
            <p class="my_font">г. Санкт-Петербург,</p>
            <p class="my_font">ул. Куйбышева 31</p>
        </div>
    </div>
    <div class="contacts flex-center flex-row">
        <a href="./user"><img src="./assets/profile.png" alt="Профиль" class="profile"></a>
        <?php if (true): ?>
            <a href="./authorization">Авторизация</a>
            <a href="./admin">Админ</a>
        <?php else: ?>
            <a href="./authorization"><img src="./assets/basket.png" alt="Корзина" class="basket"></a>
        <?php endif; ?>
    </div>
</header>