<?php
require_once "config.php";
require 'imports/user.php';

if ($_SESSION['backAuth'] == true) {
	header('Location: '. route);
}
?>
<html lang="ru">
<head>
	<title>Mereph Connect</title>
	<link rel="stylesheet" href="<?=route?>/assets/authentication.css"/>
	<link rel="stylesheet" href="<?=route?>/assets/auth.css"/>
	<?php require_once "modules/metaTags.php" ?>
</head>
<body>
	<div class="center_div" style="margin: -400px 0 0 -190px;">
		<img src="<?=route?>/assets/image/connect.webp" width="281" height="73" alt="connect_logo">
		<div class="box">
			<h2>Регистрация</h2>
			<?php
			if (isset($_POST['auth'])) {
				$reply = newUser($_POST['firstname'], $_POST['surname'], $_POST['email'], $_POST['password']);
				echo "<h3>Ошибка входа<br>$reply</h3>";
			}
			?>
			<form method="POST">
				<label>
					<span>Имя</span>
					<input type="text" maxlength="32" name="firstname" placeholder="Михаил" autocomplete="given-name">
				</label>
				<label>
					<span>Фамилия</span>
					<input type="text" maxlength="32" name="lastname" placeholder="Смирнов" autocomplete="family-name">
				</label>
				<label>
					<span>E-mail</span>
					<input type="email" maxlength="64" name="email" placeholder="user@example.com" autocomplete="email">
				</label>
				<label>
					<span>Пароль</span>
					<input type="password" maxlength="32" minlength="8" placeholder="••••••••" autocomplete="new-password">
				</label>
				<button name="auth" class="auth_box_submit">Продолжить</button>
			</form>
			<a href="auth">Уже есть аккаунт</a>
		</div>
		<p class="use">
			Нажимая кнопку «Продолжить» вы соглашаетесь с
			<a class="mark--main" href="<?=route?>/terms.php">Условиями использования</a>
			сервиса.
		</p>
	</div>
</body>
</html>
