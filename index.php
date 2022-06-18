<?php
require_once "config.php";
require_once "imports/db.php";
require_once "imports/utils/product.php";
require_once "imports/utils/user.php";

require_once "modules/forms/productItem.php";
require_once "modules/forms/partnershipItem.php";
require_once "modules/forms/userBadge.php";
require_once "modules/header.php";

function display_products(mysqli_result $products): string {
	$output = "";
	while ($product = $products->fetch_object()) {
		$output .= productItem($product);
	}
	return $output;
}

$products = get_products();
$isNoProducts = $products->num_rows == 0;

$user = null;

if (isset($_COOKIE["MC-token"])) {
	$cookie = readCookie();
	if ($cookie != null) {
		$user = getUser($cookie->userId);
		if ($user != null) {
			$serverHash = md5($user->password.":".password_hash_key);
			if ($serverHash != $cookie->passwordHash) {
				$user = null;
			}
		}
	}
}

?>
<html lang="ru">
<head>
	<title>Mereph</title>
	<link rel="stylesheet" href="assets/index.css">
	<?php require_once "modules/metaTags.php" ?>
</head>
<body>
<?= _header($user) ?>
<div class="middle">
	<div class="middle__left">
		<h1>
			Взломай сервер мгновенно уже <span class="mark--main">сегодня</span>
		</h1>
		<p>
			Мы даем возможность игрокам майнкрафт проектов получать желаемый донат прямо сейчас.
			Без всяких знаний и навыков программирования.
		</p>
		<div>
			<a href="https://oxy.cloud/d/uKTe" target="_blank" class="button_link">
				<button class="button--big">
					Установить
				</button>
			</a>
		</div>
	</div>
	<div class="middle__right">
		<img src="assets/image/1.webp" width="296" height="488" alt="preview">
	</div>
</div>
<section>
	<h1>Магазин</h1>
	<p>Здесь ты найдёшь товар на свой вкус</p>
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
	<p>Партнёры нашей экосистемы</p>
	<article class="partnership">
		<?=
		partnershipItem("TesloudHack", [
			"link" => route . "/assets/image/svg/tesloud.svg",
		], "https://www.youtube.com/channel/UCd154PLYipdIYNTMVaBxVOg")
		. partnershipItem("KinalHack", [
			"link" => route . "/assets/image/svg/kinal.svg",
		], "https://www.youtube.com/channel/UCsft9V97hT5NONxzMv39Slg")
		. partnershipItem("FlashBullet", [
			"link" => route . "/assets/image/svg/flash.svg",
		], "https://www.youtube.com/channel/UCOo9S7lkBp0E_7dnXYCIGxQ")
		?>
	</article>
</section>
<footer>
	<p>© Все права защищены Mereph.ru</p>
</footer>
</body>
</html>
