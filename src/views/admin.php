<main>
	<div class="container_con">
		<section class="section_con">
			<h1>Добавить новый продукт</h1>
			<?php

			use ProductHack\components\Form;
			use ProductHack\models\ImageModel;

			$addProductForm = Form::beginWithFile("/api/product/create") ?>
			<?php $addProductForm->field("name", "Название", "text") ?>
			<?php $addProductForm->field("description", "Описание", "text") ?>
			<?php $addProductForm->field("price", "Цена", "number") ?>
			<?php $addProductForm->field("stock", "Количество", "number") ?>
			<?php $addProductForm->fieldFile("base64", "Изображение", "image/*") ?>
			<?php Form::end("Добавить продукт") ?>
		</section>

		<section class="section_con">
			<h1>Удалить продукт</h1>
			<?php $deleteProductForm = Form::begin("/api/product/delete") ?>
			<?php $deleteProductForm->field("id", "Номер продукта", "number") ?>
			<?php Form::end("Удалить продукт") ?>
		</section>


		<section class="section_con">
			<h1>Товары</h1>
			<div class='list'>
				<?php

				use ProductHack\models\ProductModel;

				$productModel = new ProductModel();
				foreach ($productModel->selectAll() as $row):
					?>
					<div class='item'>
						<p>ID: <?php echo $row["id"] ?></p>
						<p>name: <?php echo $row["name"] ?></p>
						<p>description: <?php echo $row["description"] ?></p>
						<p>price: <?php echo $row["price"] ?></p>
						<p>stock: <?php echo $row["stock"] ?></p>
					</div>
				<?php endforeach; ?>
			</div>

		</section>

		<section class="section_con">
			<h1>Добавить изображение</h1>
			<?php $addImageForm = Form::beginWithFile("/api/image/create") ?>
			<?php $addImageForm->field("tag", "Тег", "text") ?>
			<?php $addImageForm->fieldFile("base64", "Изображение", "file") ?>
			<?php Form::end("Добавить") ?>
		</section>

		<section class="section_con">
			<h1>Удалить изображение</h1>
			<?php $addImageForm = Form::beginWithFile("/api/image/delete") ?>
			<?php $addImageForm->field("id", "ID", "number") ?>
			<?php Form::end("Удалить") ?>
		</section>

		<section class="section_con">
			<h1>Изображения</h1>
			<div class='list'>
				<?php

				use ProductHack\models\ImagesModel;

				$imagesModel = new ImagesModel();
				$imagesModel->loadAll();
				/** @var ImageModel */
				foreach ($imagesModel->pool as $imageModel):
					?>
					<div class='item'>
						<p>ID: <?php echo $imageModel->id ?></p>
						<p>Tag: <?php echo $imageModel->tag ?></p>
						<img class='admin-image' src='<?php echo $imageModel->base64 ?>' />
					</div>
				<?php endforeach; ?>
			</div>
		</section>
	</div>

</main>