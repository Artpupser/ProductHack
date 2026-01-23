<?php
use ProductHack\models\SessionModel;
$sessionModel = new SessionModel();
$user = null;
if ($sessionModel->loadFromPHPSESSID()) {
	$user = $sessionModel->getUser();

}
const MESSAGE = 'Пусто';
?>

<div class="container_con">
	<section class="section_con profile-section">
		<div class="profile-header">
			<h2>Профиль пользователя</h2>
		</div>
		<div class="user-info profile-card">
			<div class="info-row">
				<span class="info-label">ID:</span>
				<span class="info-value" id="full_name"><?php echo $user->id ?? MESSAGE ?></span>
			</div>
			<div class="info-row">
				<span class="info-label">Полное имя:</span>
				<span class="info-value" id="full_name"><?php echo $user->full_name ?? MESSAGE ?></span>
			</div>
			<div class="info-row">
				<span class="info-label">Роль:</span>
				<span class="info-value" id="user_role"><?php echo match ($user->role_id) {
					1 => "Покупатель",
					2 => "Администратор",
				} ?? $message ?></span>
			</div>
			<div class="info-row">
				<span class="info-label">Почта:</span>
				<span class="info-value" id="email"><?php echo $user->email ?? MESSAGE ?></span>
			</div>

		</div>
		<form class="contact-form" method="POST" action="/api/user/logout">
			<button type="submit">Выйти из аккаунта</button>
		</form>
	</section>

	<section class="section_con profile-section">
		<div class="orders-section">
			<h2 class="section-title">Ваши заказы</h2>

			<div class="orders-container">
				<h3>Ожидают доставки</h3>
				<div class="orders-list active" id="pending-orders">
				</div>
				<h3>Завершенные</h3>
				<div class="orders-list" id="completed-orders">
				</div>
			</div>
		</div>
	</section>
</div>