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

		foreach ($model as $value): ?>
			<div class="card">
				<img class="card_img" src="<?php
				$images = new ImagesModel();
				echo $images->selectWhereEqual("id", explode(',', $value['ids_images'])[0])[0]["base64"] ?>" />
				<div class="card_content">
					<div class="card_title"><?php echo $value['name'] ?></div>
					<div class="card_sub">
						<p>Описание: <?php echo $value['description'] ?></p>
						<p>Кол-во: <?php echo $value['stock'] ?></p>
					</div>
					<div class="price_card"><?php echo $value['price'] ?>₽</div>
					<div class='btn-card'>
						<a class='btn' href='#'>Добавить в корзину</a>
					</div>
				</div>
			</div>
		<?php endforeach ?>
	</div>
	<script src="/api/public/file/?name=js/catalog.js"></script>