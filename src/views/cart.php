<section class="section_cart">
	<div class="cart-wrapper">
		<h2 class="cart-title">Корзина</h2>

		<div id="cart-list" class="cart-list">
			<div class="content_card_prod">
				<img class="wine_card_prod" src="../../assets/wine1.jpg" alt="card" />
				<div class="box_card_prod">
					<h2>Название вина</h2> <br>
					Тип: красно, сухое<br>
					Регион: Франция <br>
					<p class="small-text">
						Любителей австралийских вин хочу предупредить, что шираз Mr Borio's совершенно не похож на «тёзку» с
						другого континента.
					</p>
				</div>

			</div>
		</div>

		<div class="cart-total">
			<span class="cart-total-label">Итого:</span>
			<span id="cart-total-price" class="cart-total-price"> ₽</span>
		</div>

		<form action="/payment" method="GET" class="cart-form">
			<button type="submit" class="cart-btn">Оформить заказ</button>
		</form>
	</div>
</section>