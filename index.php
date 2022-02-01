<?php
session_start();
require_once "config.php";
/* @var mysqli $db */
require_once "imports/db.php";
require_once "imports/utils/product.php";

require_once "modules/forms/productItem.php";

require 'imports/user.php';

$accountCurrent = false;
$account = null;
if ($_SESSION['newEmail'] != null && $_SESSION['newPassword'] != null) {
	$account = getUser($_SESSION['newEmail'], $_SESSION['newPassword'], "/");
	$accountCurrent = true;
}

function display_products(mysqli_result $products): string
{
	$output = "";
	while ($product = $products->fetch_object()) {
		$output .= productItem($product);
	}
	return $output;
}

$products = get_products();
$isNoProducts = $products->num_rows == 0;

?>
<html lang="ru">
<head>
	<title>Mereph</title>
	<link rel="stylesheet" href="assets/style.css">
	<link rel="stylesheet" href="assets/index.css">
	<?php require_once "modules/metaTags.php" ?>
</head>
<body>
<script>
	function profile() {
		document.location.href = "https://mereph.ru/profile/";
	}
</script>
<div class="header">
	<img src="assets/image/dark_logo.webp" width="100" height="100">
	<?
	if ($accountCurrent == true) {
		?>
		<a onclick="profile()" class="header_user"><? echo $account['firstname'] . " " . $account['surname'] ?>
			⠀<span><?= $account['balance'] ?>₽</span></a>
		<?
	} else {
		?>
		<a href="auth" class="header_auth">Авторизация</a>
		<?
	}
	?>
</div>

<div class="middle">
	<div class="middle__left">
		<h1>
			Взломай сервер мгновенно уже <span class="mark--main">сегодня</span>
		</h1>
		<p>
			Мы даем возможность игрокам майнкрафт проектов получать желаемый донат прямо сейчас.
			Без всяких знаний и навыков программирование.
		</p>
		<div>
			<a href="https://oxy.cloud/d/uKTe" class="button_link">
				<button class="button--big">
					Установить
				</button>
			</a>
		</div>
	</div>
	<div class="middle__right">
		<img src="assets/image/1.webp" width="370" height="611" alt="preview">
	</div>
</div>


<center>

	<div class="central_title">
		<h1>Магазин</h1>
		<p>Найди любой товар на свой вкус</p>
	</div>

	<section>
		<h1>Магазин</h1>
		<p>Найди любой товар на свой вкус</p>
		<article class="product-list<?= $isNoProducts ? " product-list--empty" : "" ?>">
			<?=
			$isNoProducts
				? "<h2>Нет товаров</h2>"
				: display_products($products)
			?>
		</article>
	</section>

	<div class="product-list<?= $isNoProducts ? " product-list--empty" : "" ?>">
		<?=
		$isNoProducts
			? "<h2>Нет товаров</h2>"
			: display_products($products)
		?>
	</div>


	<div class="central_title">
		<h1>Экосистема</h1>
		<p>Поддерживаемые партнёры нашей системы</p>
	</div>

	<div class="ecosystem">

		<div class="ecosystem_support">
			<div class="ecosystem_support_tab">
				<h3>TesloudHack</h3>
				<div class="align_sphere">
					<div class="sphere"></div>
					<div class="sphere" style="background: #C4C4C4;"></div>
				</div>
			</div>
			<img src="assets/image/svg/tesloud.svg">
			<a href="https://www.youtube.com/channel/UCd154PLYipdIYNTMVaBxVOg" target="_blank">Продолжить</a>
		</div>

		<div class="ecosystem_support">
			<div class="ecosystem_support_tab">
				<h3>KinalHack</h3>
				<div class="align_sphere">
					<div class="sphere"></div>
					<div class="sphere" style="background: #C4C4C4;"></div>
				</div>
			</div>
			<img src="assets/image/svg/kinal.svg">
			<a href="https://www.youtube.com/channel/UCsft9V97hT5NONxzMv39Slg" target="_blank">Продолжить</a>
		</div>

		<div class="ecosystem_support">
			<div class="ecosystem_support_tab">
				<h3>FlashBullet</h3>
				<div class="align_sphere">
					<div class="sphere"></div>
					<div class="sphere" style="background: #C4C4C4;"></div>
				</div>
			</div>
			<img src="assets/image/svg/flash.svg">
			<a href="https://www.youtube.com/channel/UCOo9S7lkBp0E_7dnXYCIGxQ" target="_blank">Продолжить</a>
		</div>

	</div>
	<p class="access">© Все права защищены Mereph.ru</p>

</center>

</body
</html>
