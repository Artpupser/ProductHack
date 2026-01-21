<main>
	<div class="container_con">
		<section class="section_con">


			<h1>Добавить новый продукт</h1>
			<form action="/api/product/create" method="POST" enctype="multipart/form-data" class="contact-form">
				<label for="name">Названеи:</label>
				<input type="text" id="name" name="name" required maxlength="150">

				<label for="description">Описание:</label>
				<textarea id="description" name="description"></textarea>

				<label for="price">Цена:</label>
				<input type="number" id="price" name="price" required step="0.01" min="0">

				<label for="stock">Количество:</label>
				<input type="number" id="stock" name="stock" required min="0" value="0">

				<label for="image">Изображение:</label>
				<input type="file" id="image" name="image" accept="image/*">

				<button type="submit">Добавить продукт</button>
			</form>
		</section>
		<section class="section_con">

			<h1>Добавить изображение</h1>
			<form action="/api/product/create" method="POST" enctype="multipart/form-data" class="contact-form">
				<label for="image">Цена:</label>
				<input type="number" id="price" name="price" required step="0.01" min="0">

				<label for="image">Изображение:</label>
				<input type="file" id="image" name="image1" accept="image1/*">

				<button type="submit">Добавить продукт</button>
			</form>

		</section>
		<section class="section_con">
			<h1>Удалить продукт</h1>
			<form action="/api/product/delete" method="POST" enctype="multipart/form-data" class="contact-form">
				<label for="id">ID продукта:</label>
				<input type="number" id="id" name="id" required>
				<button type="submit">Удалить продукт</button>
			</form>

		</section>
		<section class="section_con">
			<h1>Товары</h1>
			<div class='list'>
				<?php

				use ProductHack\models\ProductModel;

				$productModel = new ProductModel();
				foreach ($productModel->selectAll() as $value):
					?>
					<div class='item'><?php echo var_dump($value) ?></div>
				<?php endforeach; ?>
			</div>

		</section>
		<section class="section_con">
			<h1>Изображения</h1>
			<div class='list'>
				<?php

				use ProductHack\models\ImagesModel;

				$imagesModel = new ImagesModel();
				foreach ($imagesModel->selectAll() as $value):
					?>
					<div class='item'>
						<p>ID: <?php echo $value["id"] ?></p>
						<img alt='img' src='<?php echo $value["base64"] ?>' />
					</div>
				<?php endforeach; ?>
			</div>
		</section>
	</div>

</main>