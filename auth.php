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
		<form method="POST" action="<?=route?>/provider/user/login.php">
			<h2>Авторизация</h2>
			<label>
				<span>Логин / Email</span>
				<input type="text" minlength="3" maxlength="64" name="user" placeholder="misha" autocomplete="nickname" required>
			</label>
			<label>
				<span>Пароль</span>
				<input type="password" name="password" maxlength="32" minlength="8" placeholder="••••••••" autocomplete="current-password" required>
			</label>
			<button>Войти</button>
			<a href="<?=route?>/register.php">Создать новый аккаунт</a>
		</form>
	</div>
</body>
</html>
