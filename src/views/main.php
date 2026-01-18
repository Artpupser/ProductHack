<main>
	<div class="background-container">
		<div class="bg-1">
			<h1 class="vinishko">Винишко на все <br> случаи жизни</h1>
			<button class="butcat" onclick="window.location.href='./catalog'">Перейти в каталог</button>
		</div>
		<div class="bg-2">

			<div class="slider">
				<?php

				use ProductHack\models\ImagesModel;

				$imagesModel = new ImagesModel();
				foreach ($imagesModel->selectRandom(3) as $value): ?>
					<img class="slider-img" src="<?php echo $value["base64"] ?>" alt="Слайд 1">
				<?php endforeach; ?>
				<div class="controls">
					<img style="opacity: 1; height: 40px;" class="left controlls" src="../assets/imgs/left_switch_icon.webp" alt="Слева">
					<img style="opacity: 1; height: 40px;" class="right controlls" src="../assets/imgs/right_switch_icon.webp" alt="Справа">
				</div>
			</div>
			<a href="/catalog" class="ssilka" >
				Перейти в каталог</a>
		</div>



		<div class="acii">
			<img src="../assets/imgs/sale_banner.webp" alt="">
		</div>

</main>