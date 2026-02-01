<section class="section_cart">
	<div class="cart-wrapper">
		<h2 class="cart-title">Корзина</h2>
		<?php $amount = 0 ?>
		<div id="cart-list" class="cart-list">
			<?php
			use ProductHack\models\CartModel;

			foreach (new CartModel()->getProducts() as $key => $product): ?>
				<div class="content_card_prod">
					<img class="wine_card_prod" src="<?php echo $product->getFirstImage() ?>" alt="card" />
					<div class="box_card_prod">
						<h2><?php echo $product->name ?></h2>
						<h2><?php echo $_SESSION['cart'][$key] ?></h2>
						<h2><?php $amount += $product->price;
						echo $product->price ?>₽</h2>
						<p class="small-text">
							<?php echo $product->description ?>
						</p>
					</div>
				</div>
			<?php endforeach ?>
		</div>

		<div class="cart-total">
			<span class="cart-total-label">Итого:</span>
			<span id="cart-total-price" class="cart-total-price"><?php echo $amount ?> ₽</span>
		</div>

		<form action="/payment" method="GET" class="cart-form">
			<button type="submit" class="cart-btn">Оформить заказ</button>
		</form>
	</div>
</section>