<?php

use ProductHack\core\Session;
use ProductHack\models\ImageModel;
use ProductHack\models\OrderModel;
use ProductHack\models\OrdersModel;
use ProductHack\models\OrderStatus;

$user = Session::$CURRENT?->getUser() ?? null;
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
				<input type="text" id="edit_full_name" name="full_name" placeholder="Введите полное имя"
					value="<?php echo $user->full_name ?? '' ?>" required />

				<label for="edit_email">Почта</label>
				<input type="email" id="edit_email" name="email" placeholder="Введите почту"
					value="<?php echo $user->email ?? '' ?>" required />

				<label for="edit_password">Новый пароль (оставьте пустым, если не хотите менять)</label>
				<input type="password" id="edit_password" name="password" placeholder="Введите новый пароль" />

				<label for="edit_repeat_password">Повторите новый пароль</label>
				<input type="password" id="edit_repeat_password" name="repeat_password"
					placeholder="Повторите новый пароль" />

				<button type="submit">Сохранить</button>
				<button type="button" onclick="hideEditForm()">Отмена</button>
			</form>
		</div>


	</section>

	<section class="section_con profile-section">
		<div class="orders-section">
			<h2 class="section-title">Ваши заказы</h2>

			<div class="orders-container">
				<?php
				$ordersModel = new OrdersModel();
				$ordersModel->loadAll();

				if (\count($ordersModel->pool) != 0):
					/**
					 * @var OrderModel
					 */
					foreach ($ordersModel->pool as $orderModel): ?>
						<div class="order">
							<div class="order-info"><?php echo $orderModel->id ?></div>
							<div class="order-info"><?php echo $orderModel->status->name ?></div>
							<div class="order-info"><?php echo $orderModel->total_price ?></div>
							<?php foreach ($orderModel->getOrderItemModels() as $orderItemModel): ?>
								<div class="order-item">
									<?php $product = $orderItemModel->product(); ?>
									<div class="order-item-info"><?php echo $orderItemModel->id ?></div>
									<div class="order-item-info"><?php echo $orderItemModel->product_id ?></div>
									<div class="order-item-info"><?php echo $orderItemModel->order_id ?></div>
									<div class="order-item-info"><?php echo $orderItemModel->amount ?></div>
									<div class="order-item-info"><?php echo $orderItemModel->price_snapshot ?></div>
									<div class="order-item-info"><?php echo $product->name ?></div>
									<div class="order-item-info"><?php echo $product->description ?></div>
									<img class="order-item-info img" src='<?php /** @var ImageModel */
									$image = $product->getImages()->getFirst();
									echo $image->base64; ?>' />
								</div>
							<?php endforeach ?>
							<?php
							if ($orderModel->status == OrderStatus::CREATED) {
								echo "<button class='btn'>Оплатить</button>";
							} else {
								echo "<div class='order-info'>ОПЛАЧЕНО</div>";
							}
							?>
						</div>
					<?php endforeach ?>
				<?php else: ?>
					<div class="order-info">У вас не было заказов</div>
				<?php endif ?>
			</div>
		</div>
	</section>
	<section ection class="section_con profile-section">
		<div class="profile-header">
			<form class="contact-form" method="POST" action="/api/user/logout">
				<button type="submit">Выйти из аккаунта</button>
			</form>
		</div>
	</section>
</div>
<script src="/api/public/file/?name=js/profile.js"></script>