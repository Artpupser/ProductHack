<body class="body_cat">
	<div class="catalog-row">
		<div class="img_catalog">
			<div>
				<img src="/api/public/file/?name=imgs/bg_for_catalog_button.webp" alt="catalog">
				<h1 class="my_font">Каталог</h1>
			</div>
		</div>
		<div class="searc_form">
			<div class="search_wrapper">
				<input type="search" id="search" name="q" placeholder=" ">
				<button type="submit">
					<img src="/api/public/file/?name=imgs/search_icon.webp" alt="Search">
				</button>
			</div>
		</div>

		<div class="img_filter">
			<div>
				<img src="/api/public/file/?name=imgs/bg_for_filter_button.webp" alt="filter">
				<h2 class="my_font">Фильтрация</h2>
			</div>
		</div>
	</div>

	<div class="cards-container">
		<?php
		use ProductHack\models\ImagesModel;
		use ProductHack\models\ProductsModel;
		$products = new ProductsModel();
		$products->loadAll();
		foreach ($products->pool as $product): ?>
			<?php
			$imagesModel = new ImagesModel();
			$imagesModel->loadFromTag($product->getTagForImage()); ?>
			<div class="card">
				<img class="card_img" src="
				<?php echo $imagesModel->getFirst()->base64; ?>" />
				<div class=" card_content">
					<div class="card_title"><?php echo $product->name ?></div>
					<div class="card_id"><?php echo $product->id ?></div>
					<div class="card_sub">
						<p>Описание: <?php echo $product->description ?></p>
						<p>Кол-во: <?php echo $product->stock ?></p>
					</div>
					<div class="quantity-control">
						<button type="button" class="qty-btn minus">−</button>
						<span class="qty-number">1</span>
						<button type="button" class="qty-btn plus">+</button>
					</div>
					<div class="price_card"><?php echo $product->price ?>₽</div>
					<div class='btn-card'>
						<a class='btn' href='#'>Добавить в корзину</a>
					</div>
				</div>
			</div>
		<?php endforeach ?>
	</div>
	<script src="/api/public/file/?name=js/test.js"></script>
	<script src="/api/public/file/?name=js/catalog.js"></script>