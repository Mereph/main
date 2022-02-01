<?php
/* @var mysqli $db */
require_once "config.php";
require_once "imports/db.php";
require_once "imports/utils/product.php";

require_once "modules/forms/productItem.php";
require_once "modules/forms/partnershipItem.php";

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

	<section>
		<h1>Экосистема</h1>
		<p>Поддерживаемые партнёры нашей системы</p>
		<article class="partnership">
			<?=
				partnershipItem("TesloudHack", [
					"link" => route."/assets/image/svg/tesloud.svg",
				], "https://www.youtube.com/channel/UCd154PLYipdIYNTMVaBxVOg")
				.partnershipItem("KinalHack", [
					"link" => route."/assets/image/svg/kinal.svg",
				], "https://www.youtube.com/channel/UCsft9V97hT5NONxzMv39Slg")
				.partnershipItem("FlashBullet", [
					"link" => route."/assets/image/svg/flash.svg",
				], "https://www.youtube.com/channel/UCOo9S7lkBp0E_7dnXYCIGxQ")
			?>
		</article>
	</section>

	<footer>
		<p>© Все права защищены Mereph.ru</p>
	</footer>

</center>

</body>
</html>
