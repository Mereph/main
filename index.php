<?php
session_start();
require_once "config.php";
/* @var mysqli $db */
require_once "imports/db.php";

require_once "modules/forms/productItem.php";

require 'imports/user.php';

$accountCurrent = false;
$account = null;
if ($_SESSION['newEmail'] != null && $_SESSION['newPassword'] != null) {
  $account = getUser($_SESSION['newEmail'], $_SESSION['newPassword'], "/");
  $accountCurrent = true;
}

function display_products(): string
{
  global $db;
  $products = $db->query("
        SELECT `id`, `name`, `description`, `price`
        FROM `" . sql_database . "`.`" . db_products_list . "`
        ORDER BY UNIX_TIMESTAMP(`createdAt`) DESC
    ");
  $output = "";
  while ($product = $products->fetch_object()) {
    $output .= productItem($product);
  }
  return $output;
}

?>
<html lang="ru">
<head>
    <title>Mereph</title>
    <link rel="stylesheet" href="assets/style.css"/>
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
    <div class="middle_left">
        <h2><span style="color: EE6C90;">В</span>зломай сервер мгновенно уже <span style="color: EE6C90;">сегодня</span>
        </h2>
        <p>Мы даем возможность игрокам проектов майнкрафт, получить желаемый донат прямо сейчас без знание навыков
            программирование</p>
        <a href="https://oxy.cloud/d/uKTe">Установить</a>
    </div>
    <div class="middle_right">
        <img src="assets/image/1.webp">
    </div>
</div>


<center>

    <div class="central_title">
        <h1>Магазин</h1>
        <p>Найди любой товар на свой вкус</p>
    </div>

    <div class="shop">

      <?= display_products() ?>

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
