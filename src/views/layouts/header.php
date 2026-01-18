<header class="header_main">
	<div class="logo">
		<a href="http://localhost:8000/"><img src="../../assets/imgs/logo_icon.webp" alt="Логотип"></a>
	</div>
	<p class="wineshop">Винный магазин</p>
	<div class="place flex-center flex-row">
		<div class="img-place">
			<img src="./assets/imgs/place_icon.webp" alt="Местоположение">
		</div>
		<div class="flex-column">
			<p class="my_font">г. Санкт-Петербург,</p>
			<p class="my_font">ул. Куйбышева 31</p>
		</div>
	</div>
	<div class="contacts flex-center flex-row">
		<?php if (true): ?>
			<a href="./authorization"><img src="./assets/imgs/profile_icon.webp" alt="Профиль" class="profile"></a>
			<a href="./admin"><img src="./assets/imgs/admin_icon.webp" alt="Профиль" class="admin"></a>
		<?php else: ?>
			<a href="./authorization"><img src="./assets/basket.png" alt="Корзина" class="basket"></a>
		<?php endif; ?>
	</div>
</header>