<?php
require_once "config.php";
require 'imports/user.php';
?>
<html lang="ru">
<head>
	<title>Mereph Connect</title>
	<link rel="stylesheet" href="<?=route?>/assets/authentication.css"/>
	<?php require_once "modules/metaTags.php" ?>
</head>
<body>
	<div class="container">
		<a class="button_link" href="<?=route."/"?>">
			<img src="<?=route?>/assets/image/connect.webp" width="281" height="73" alt="connect_logo">
		</a>
		<form method="POST" action="<?=route?>/provider/user/create.php">
			<h2>Регистрация</h2>
			<label>
				<span>Логин</span>
				<input type="text" minlength="3" maxlength="24" name="login" placeholder="misha" autocomplete="nickname" required>
			</label>
			<div class="split_grid">
				<label>
					<span>Имя</span>
					<input type="text" maxlength="32" name="firstname" placeholder="Михаил" autocomplete="given-name" required>
				</label>
				<label>
					<span>Фамилия</span>
					<input type="text" maxlength="32" name="lastname" placeholder="Смирнов" autocomplete="family-name" required>
				</label>
			</div>
			<label>
				<span>E-mail</span>
				<input type="email" maxlength="64" name="email" placeholder="user@example.com" autocomplete="email" required>
			</label>
			<label>
				<span>Пароль</span>
				<input type="password" name="password" maxlength="32" minlength="8" placeholder="••••••••" autocomplete="new-password" required>
			</label>
			<button name="tos" value="1">Продолжить</button>
			<a href="<?=route?>/auth.php">Уже есть аккаунт</a>
		</form>
		<p>
			Нажимая кнопку «Продолжить» вы соглашаетесь с
			<a class="mark--main" href="<?=route?>/terms.php">Условиями использования</a>
			сервиса.
		</p>
	</div>
</body>
</html>
