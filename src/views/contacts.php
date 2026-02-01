<h1 class="h1-con">Контакты</h1>
<div class="container_con">
	<section class="section_con">
		<h2>Свяжитесь с нами</h2>
		<?php
		use ProductHack\components\Form;
		$loginForm = Form::begin("/api/user/login") ?>
		<?php $loginForm->field("name", "Имя", "text"); ?>
		<?php $loginForm->field("email", "Почта", "email"); ?>
		<?php $loginForm->fieldMessage("message", "Сообщение", "text"); ?>
		<?php Form::end("Отправить") ?>
	</section>

	<section class="section_con">
		<h2>Наши контакты</h2>
		<p><strong>Адрес:</strong> ул. Щедрина 43, Рязань</p>
		<p><strong>Телефон:</strong> +7(920)999-46-56</p>
		<p><strong>Email:</strong> rzn@top-academy.ru</p>
	</section>
</div>