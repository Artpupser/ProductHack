<header class="header_main">
	<div class="logo">
		<a href="/"><img src="/api/public/file/?name=imgs/logo_icon.webp" alt="Логотип"></a>
	</div>
	<p class="wineshop"><?php echo $pageTitle ?></p>
	
	<div class="contacts flex-center flex-row">
		<?php
		use ProductHack\models\SessionModel;
		$sessionModel = new SessionModel();
		if ($sessionModel->loadFromPHPSESSID()): ?>
			<?php
			$user = $sessionModel->getUser();
			if ($user->role_id == 2): ?>
				<a href="./admin"><img src="/api/public/file/?name=imgs/admin_icon.webp" alt="Admin panel" class="admin"></a>
			<?php endif; ?>
		<?php endif; ?>
		<a href="./authorization"><img src="/api/public/file/?name=imgs/profile_icon.webp" alt="Авторизация" class="profile"></a>
		<a href="./cart"><img src="/api/public/file/?name=imgs/basket_icon.webp" alt="Корзина" class="cart"></a>
	</div>
</header>