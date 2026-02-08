<section class="section_cart">
	<div class="cart-wrapper">
		<h2 class="cart-title">Корзина</h2>
		<div id="cart-list" class="cart-list">
			<?php

			use ProductHack\components\Form;
			use ProductHack\models\CartModel;
			$cart = new CartModel();
			$cart->loadCart();
			foreach ($cart->cartItems as $key => $value): ?>
				<div class="content_card_prod">
					<img class="wine_card_prod" src="<?php echo $cart->products[$key]->getImages()->getFirst()->base64 ?>"
						alt="card" />
					<div class="box_card_prod">
						<h2><?php echo $cart->products[$key]->name ?></h2>
						<h2><?php echo $value->cost ?></h2>
						<h2><?php echo $cart->priceProduct($key) ?>₽</h2>
						<h2><?php echo $value->enable ?></h2>
						<p class="small-text"><?php echo $cart->products[$key]->description ?></p>
						
						<button class="change-enable"
							data-id="<?= $key ?>"
							data-cost="<?= $value->cost ?>"
							data-enable="<?= $value->enable ?>">
							Учесть/Не учитывать
						</button>

						<button class="remove-item" data-id="<?= $key ?>">
							Убрать из корзины
						</button>


					</div>
				</div>
			<?php endforeach ?>
		</div>

		<div class="cart-total">
			<span class="cart-total-label">Итого:</span>
			<span id="cart-total-price" class="cart-total-price"><?php echo $cart->total() ?> ₽</span>
		</div>
		<?php $form = Form::begin("api/order/create"); ?>
		<?php $form->end("Заказать") ?>
	</div>
</section>
	<script src="/api/public/file/?name=js/test.js"></script>
