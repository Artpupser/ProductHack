<main class="body_main">
	<div class="background-container">
		<div class="bg-1">

			<h1 class="vinishko">Винишко на все <br> случаи жизни</h1>
			<button class="butcat" onclick="window.location.href='./catalog'">Перейти в каталог</button>
		</div>
		<div class="bg-2">

			<div class="slider">
				<?php for ($i = 1; $i <= 4; $i++)
					echo "<img class=\"slider-img\" src=\"/api/public/file/?name=imgs/$i.webp\" alt=\"Слайд 1\">" ?>
					<div class="controls">
						<img style="opacity: 1; height: 40px;" class="left_controlls"
							src="/api/public/file/?name=imgs/left_switch_icon.webp" alt="Слева">
						<img style="opacity: 1; height: 40px;" class="right_controlls"
							src="/api/public/file/?name=imgs/right_switch_icon.webp" alt="Справа">
					</div>
				</div>
				<a href="/catalog" class="ssilka">
					Перейти в каталог</a>
			</div>



			<div class="acii">
				<img src="./api/public/file/?name=imgs/sale_banner.webp" alt="">
			</div>

	</main>
	<script src="/api/public/file/?name=js/slider.js"></script>