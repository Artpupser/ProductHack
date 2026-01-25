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
			<form class="contact-form" method="POST" action="/api/user/logout">
				<button id="edit-profile-btn" type="button" onclick="showEditForm()">Редактировать профиль</button>
			</form>

			
        </div>

        <div id="edit-form" style="display:none">
            <h2>Редактирование профиля</h2>
            <form id="edit-profile-form" class="contact-form" method="POST" action="/api/user/update">
                <label for="edit_full_name">Полное имя</label>
                <input type="text" id="edit_full_name" name="full_name" placeholder="Введите полное имя" value="<?php echo $user->full_name ?? '' ?>" required />

                <label for="edit_email">Почта</label>
                <input type="email" id="edit_email" name="email" placeholder="Введите почту" value="<?php echo $user->email ?? '' ?>" required />

                <label for="edit_password">Новый пароль (оставьте пустым, если не хотите менять)</label>
                <input type="password" id="edit_password" name="password" placeholder="Введите новый пароль" />

                <label for="edit_repeat_password">Повторите новый пароль</label>
                <input type="password" id="edit_repeat_password" name="repeat_password" placeholder="Повторите новый пароль" />

                <button type="submit">Сохранить</button>
                <button type="button" onclick="hideEditForm()">Отмена</button>
            </form>
        </div>

        
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
	<section class="section_con profile-section">
		<div class="profile-header">
			<form class="contact-form" method="POST" action="/api/user/logout">
				<button type="submit">Выйти из аккаунта</button>
			</form>
		</div>
	</section>
</div>
<script src="/api/public/file/?name=js/profile.js"></script>