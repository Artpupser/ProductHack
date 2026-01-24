<header class="header_main">
	<div class="logo">
		<a href="/"><img src="../../assets/imgs/logo_icon.webp" alt="Логотип"></a>
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
		<?php
		use ProductHack\models\SessionModel;
		$sessionModel = new SessionModel();
		if ($sessionModel->loadFromPHPSESSID()): ?>
			<?php
			$user = $sessionModel->getUser();
			if ($user->role_id == 2): ?>
				<a href="./admin"><img src="./assets/imgs/admin_icon.webp" alt="Admin panel" class="admin"></a>
			<?php endif; ?>
		<?php endif; ?>
		<a href="./authorization"><img src="./assets/imgs/profile_icon.webp" alt="Авторизация" class="profile"></a>
	</div>
</header>