<html lang="ru">
<?
session_start();
require_once "config.php";
require 'imports/user.php';
if ($_SESSION['backReview'] != null) {
	if ($_SESSION['backReview'] == true) {

	} else {
		header('Location: auth');
	}
} else {
	header('Location: register');
}
?>
<head>
	<title>Mereph Connect</title>
	<link rel="stylesheet" href="assets/auth.css"/>
	<?php require_once "modules/metaTags.php" ?>
</head>
<body>
<center>
	<div class="center_div">
		<img src="assets/image/connect.webp">
		<div class="box">
			<h2>Пересмотр</h2>
			<?
			if (isset($_POST['auth'])) {
				$check = validUser($_SESSION['newEmail'], md5(md5(trim($_POST['password']))));
				if ($check == true) {
					if ($_SESSION['appLink'] == "ok") {
						?>
						<script>window.location.href = 'https://dev.mereph.ru/new/production/success';</script>
					<?
					}else{
					?>
						<script>window.location.href = 'auth';</script>
						<?
					}
				} else {
					echo '<h3>Не забудь!<br>Твой пароль: ' . $_SESSION['review_password'] . '</h3>';
				}
			}
			?>
			<form method="POST">
				<p>Введите пароль</p>
				<input type="password" name="password" placeholder="••••••••" autocomplete="off" autofocus="off"
				       autosave="off" readonly onfocus="this.removeAttribute('readonly');">
				<button name="auth" class="auth_box_submit">Создать</button>
			</form>
			<a href="register">Вернуться на регистрацию</a>
		</div>
		<p class="use">Нажимая кнопку «Создать» вы соглашаетесь с <span
				style="color: #EE6C90;">Условиями использования</span> сервиса.</p>
	</div>
</center>
</body>
</html>
