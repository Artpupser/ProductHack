<main>
	<div class="container_con">
		<section class="section_con">
			<h1>Добавить новый продукт</h1>
			<?php

			use ProductHack\components\Form;

			$addProductForm = Form::beginWithFile("/api/product/create") ?>
			<?php $addProductForm->field("name", "Название", "text") ?>
			<?php $addProductForm->field("description", "Описание", "text") ?>
			<?php $addProductForm->field("price", "Цена", "number") ?>
			<?php $addProductForm->field("stock", "Количество", "number") ?>
			<?php $addProductForm->fieldFile("image", "Изображение", "file") ?>
			<?php Form::end("Добавить продукт") ?>
		</section>

		<section class="section_con">
			<h1>Удалить продукт</h1>
			<?php $deleteProductForm = Form::begin("/api/product/delete") ?>
			<?php $deleteProductForm->field("id", "Номер продукта", "number") ?>
			<?php Form::end("Удалить продукт") ?>
		</section>

		<section class="section_con">

			<h1>Добавить изображение</h1>
			<?php $addImageForm = Form::beginWithFile("/api/product/create") ?>
			<?php $addImageForm->field("price", "Цена", "number") ?>
			<?php $addImageForm->fieldFile("image", "Изображение", "file") ?>
			<?php Form::end("Добавить изображение") ?>

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
						<img class='admin-image' alt='img' src='<?php echo $value["base64"] ?>' />
					</div>
				<?php endforeach; ?>
			</div>
		</section>
	</div>

</main>