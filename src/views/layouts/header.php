<header class="header_main">
    <div class="logo">
            <a href="http://localhost:8000/"><img src="../../assets/logo.png" alt="Логотип"></a> 
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
        <?php if (true): ?>
            <a href="./authorization"><img src="./assets/profile.png" alt="Профиль" class="profile"></a>
            <a href="./admin"><img src="./assets/admin.png" alt="Профиль" class="admin"></a>
        <?php else: ?>
            <a href="./authorization"><img src="./assets/basket.png" alt="Корзина" class="basket"></a>
        <?php endif; ?> 
    </div>
</header>